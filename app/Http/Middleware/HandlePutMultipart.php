<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class HandlePutMultipart
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('PUT') && strpos($request->header('Content-Type'), 'multipart/form-data') !== false) {
            // Solo si no hay archivos detectados por Laravel
            if (count($request->allFiles()) === 0) {
                $this->parseMultipartPut($request);
            }
        }

        return $next($request);
    }

    protected function parseMultipartPut(Request $request)
    {
        $raw = file_get_contents('php://input');
        if (!$raw) return;

        $contentType = $request->header('Content-Type') ?? $request->server('CONTENT_TYPE');
        if (!preg_match('/boundary="?([^";]+)"?/', $contentType, $m)) return;

        $boundary = $m[1];
        $parts = preg_split("/-+$boundary/", $raw);
        if (!$parts) return;

        $post = [];
        $files = [];

        foreach ($parts as $part) {
            if (empty(trim($part))) continue;

            $sections = preg_split("/\r\n\r\n/", $part, 2);
            if (count($sections) !== 2) continue;

            $rawHeaders = trim($sections[0]);
            $body = substr($sections[1], 0, -2);

            $headerLines = preg_split("/\r\n/", $rawHeaders);
            $headers = [];
            foreach ($headerLines as $line) {
                if (strpos($line, ':') !== false) {
                    [$k, $v] = explode(':', $line, 2);
                    $headers[strtolower(trim($k))] = trim($v);
                }
            }

            if (!isset($headers['content-disposition'])) continue;
            $cd = $headers['content-disposition'];

            if (!preg_match('/name="([^"]+)"/', $cd, $mn)) continue;
            $name = $mn[1];

            if (preg_match('/filename="([^"]*)"/', $cd, $mf)) {
                $filename = $mf[1];
                $ctype = $headers['content-type'] ?? 'application/octet-stream';
                $tmpPath = tempnam(sys_get_temp_dir(), 'put_upload_');
                file_put_contents($tmpPath, $body);
                $files[$name] = new UploadedFile($tmpPath, $filename, $ctype, null, true);
            } else {
                $post[$name] = $body;
            }
        }

        $request->request->add($post);
        foreach ($files as $k => $v) {
            $request->files->set($k, $v);
        }
    }
}
