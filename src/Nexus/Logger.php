<?php
namespace Nexus;

class Logger {
    private static $maxSize = 10 * 1024 * 1024; // 10MB
    private static $maxFiles = 10;

    public static function log(string $message, string $level = 'INFO'): void {
        $logDir = __DIR__ . '/../logs';
        $logFile = "$logDir/system.log";

        if (!is_dir($logDir)) { @mkdir($logDir, 0775, true); }

        // --- THE ROTATION GUARD ---
        if (file_exists($logFile) && filesize($logFile) > self::$maxSize) {
            $timestamp = date('Y-m-d\TH-i-s'); // ISO 8601-ish for filenames
            rename($logFile, "$logDir/$timestamp-system.log");
            
            // Cleanup: Keep only the last 10 files
            $files = glob("$logDir/*-system.log");
            if (count($files) > self::$maxFiles) {
                array_multisort(array_map('filemtime', $files), SORT_ASC, $files);
                unlink($files[0]); // Delete the oldest one
            }
        }

        $now = date('Y-m-d H:i:s');
        $entry = "[$now] [$level] $message" . PHP_EOL;
        @file_put_contents($logFile, $entry, FILE_APPEND);
    }
}