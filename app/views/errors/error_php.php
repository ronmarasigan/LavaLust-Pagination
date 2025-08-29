<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 * 
 * Copyright (c) 2020 Ronald M. Marasigan
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @copyright Copyright 2020 (https://techron.info)
 * @since Version 1
 * @link https://lavalust.com
 * @license https://opensource.org/licenses/MIT MIT License
 */
while (ob_get_level() > 0) {
    ob_end_clean();
}
function get_code_excerpt($file, $errorLine, $padding = 5) {
    if (!is_readable($file)) return [[], 0];
    $lines = file($file);
    $start = max($errorLine - $padding - 1, 0);
    $end = min($errorLine + $padding - 1, count($lines) - 1);
    $excerpt = array_slice($lines, $start, $end - $start + 1, true);
    return [$excerpt, $start + 1];
}

list($codeExcerpt, $excerptStart) = get_code_excerpt($filepath, $line);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>⚠️ PHP Error</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 2rem;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            color: #1f2937;
        }

        .container {
            max-width: 960px;
            margin: auto;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #b91c1c;
            margin-bottom: 1.5rem;
        }

        .section { margin-bottom: 2rem; }
        .label { font-weight: bold; margin-bottom: 0.25rem; display: block; }

        .code {
            background: #f3f4f6;
            padding: 0.75rem;
            border-radius: 4px;
            font-family: 'Fira Code', monospace;
            font-size: 0.95rem;
            white-space: pre-wrap;
        }

        .code-preview {
            background-color: #1e1e1e;
            color: #dcdcdc;
            font-family: 'Fira Code', monospace;
            font-size: 14px;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            border: 1px solid #2e2e2e;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.5);
            line-height: 1.6;
        }
        .code-preview .line { display: flex; padding: 0 0.25rem; }
        .code-preview .line-number {
            width: 3em; color: #6a9955; text-align: right;
            margin-right: 1rem; user-select: none; opacity: 0.6;
        }
        .code-preview .code-line { flex: 1; white-space: pre; }
        .code-preview .highlight {
            background: #263238;
            border-left: 4px solid #f92672;
            color: #fff; font-weight: bold;
        }

        .trace-entry {
            margin-bottom: 1rem;
            padding-left: 1rem;
            border-left: 3px solid #d1d5db;
        }

        .footer {
            font-size: 0.85rem;
            color: #9ca3af;
            margin-top: 3rem;
            border-top: 1px solid #e5e7eb;
            padding-top: 1rem;
            text-align: center;
        }

        .env-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 1rem;
            border-radius: 6px;
        }

        table { width: 100%; border-collapse: collapse; }
        td {
            padding: 0.3rem 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
        }
        td:first-child { font-weight: bold; width: 25%; color: #6b7280; }
    </style>
</head>
<body>
<div class="container">
    <div class="title">⚠️ Whoops! Something went wrong.</div>

    <div class="section">
        <span class="label">Severity</span>
        <div class="code"><?php echo $severity; ?></div>
    </div>

    <div class="section">
        <span class="label">Message</span>
        <div class="code"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
    </div>

    <div class="section">
        <span class="label">Location</span>
        <div class="code"><?php echo $filepath; ?> on line <?php echo $line; ?></div>
    </div>

    <?php if (!empty($codeExcerpt)): ?>
    <div class="section">
        <h3>Code Preview</h3>
        <div class="code-preview">
<?php foreach ($codeExcerpt as $lineNum => $codeLine): ?>
    <div class="line<?php echo (($lineNum + 1) === $line) ? ' highlight' : ''; ?>">
        <span class="line-number"><?php echo str_pad($lineNum + 1, 3, ' ', STR_PAD_LEFT); ?></span>
        <span class="code-line"><?php echo htmlspecialchars(rtrim($codeLine)); ?></span>
    </div>
<?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($trace) && is_array($trace)): ?>
    <div class="section">
        <h3>Stack Trace</h3>
        <?php foreach ($trace as $entry): ?>
            <?php if (isset($entry['file'])): ?>
                <div class="trace-entry">
                    <div><strong>File:</strong> <?php echo $entry['file']; ?>:<?php echo $entry['line'] ?? 'N/A'; ?></div>
                    <div><strong>Function:</strong> <?php echo ($entry['class'] ?? '') . ($entry['type'] ?? '') . $entry['function']; ?>()</div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="section">
        <h3>Request</h3>
        <div class="env-section">
            <table>
                <tr><td>Method</td><td><?php echo $_SERVER['REQUEST_METHOD'] ?? 'N/A'; ?></td></tr>
                <tr><td>URI</td><td><?php echo $_SERVER['REQUEST_URI'] ?? 'N/A'; ?></td></tr>
                <tr><td>Query String</td><td><?php echo $_SERVER['QUERY_STRING'] ?? 'N/A'; ?></td></tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h3>Server Info</h3>
        <div class="env-section">
            <table>
                <tr><td>PHP Version</td><td><?php echo phpversion(); ?></td></tr>
                <tr><td>LavaLust Version</td><td><?php echo config_item('VERSION'); ?></td></tr>
                <tr><td>Server Software</td><td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></td></tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h3>Environment</h3>
        <div class="env-section">
            <table>
                <tr><td>GET</td><td><pre><?php print_r($_GET); ?></pre></td></tr>
                <tr><td>POST</td><td><pre><?php print_r($_POST); ?></pre></td></tr>
                <tr><td>SESSION</td><td><pre><?php echo isset($_SESSION) ? print_r($_SESSION, true) : 'No session'; ?></pre></td></tr>
                <tr><td>COOKIE</td><td><pre><?php print_r($_COOKIE); ?></pre></td></tr>
            </table>
        </div>
    </div>

    <div class="section">
        <h3>Tips</h3>
        <div class="code">
            This error page is shown because debug mode is enabled.<br>
            In production, set <code>$config['ENVIRONMENT'] = 'production'</code> to hide detailed error output.
        </div>
    </div>

    <div class="footer">
        LavaLust Framework – <?php echo date('Y'); ?> | PHP <?php echo phpversion(); ?>
    </div>
</div>
</body>
</html>
