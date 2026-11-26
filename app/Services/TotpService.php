<?php

declare(strict_types=1);

namespace App\Services;

class TotpService
{
    private const BASE32_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Generate standard 16-character Base32 secret key
     */
    public function generateSecret(int $length = 16): string
    {
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::BASE32_CHARS[random_int(0, 31)];
        }
        return $secret;
    }

    /**
     * Verify a 6-digit TOTP token against secret with window tolerance (+/- 30s)
     */
    public function verify(string $secret, string $code, int $window = 1): bool
    {
        $code = trim($code);
        if (strlen($code) !== 6 || !ctype_digit($code)) {
            return false;
        }

        $currentTimeSlice = (int) floor(time() / 30);

        for ($i = -$window; $i <= $window; $i++) {
            if ($this->calculateCode($secret, $currentTimeSlice + $i) === $code) {
                return true;
            }
        }

        return false;
    }

    /**
     * Calculate 6-digit TOTP code for a specific 30-second time slice
     */
    public function calculateCode(string $secret, int $timeSlice): string
    {
        $key = $this->base32Decode($secret);
        $time = pack('N*', 0) . pack('N*', $timeSlice);
        $hmac = hash_hmac('sha1', $time, $key, true);
        $offset = ord(substr($hmac, -1)) & 0x0F;
        $hashPart = substr($hmac, $offset, 4);
        $unpacked = unpack('N', $hashPart);
        $value = ($unpacked ? $unpacked[1] : 0) & 0x7FFFFFFF;
        $modulo = $value % 1000000;
        return str_pad((string) $modulo, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Construct otpauth:// URI for Authenticator apps (Google, Microsoft, Authy)
     */
    public function getOtpAuthUrl(string $appName, string $accountName, string $secret): string
    {
        $issuer = rawurlencode($appName);
        $account = rawurlencode($accountName);
        return "otpauth://totp/{$issuer}:{$account}?secret={$secret}&issuer={$issuer}&algorithm=SHA1&digits=6&period=30";
    }

    /**
     * Generate 8 secure, human-friendly recovery codes
     */
    public function generateRecoveryCodes(int $count = 8): array
    {
        $codes = [];
        for ($i = 0; $i < $count; $i++) {
            $part1 = bin2hex(random_bytes(2));
            $part2 = bin2hex(random_bytes(2));
            $codes[] = strtoupper("{$part1}-{$part2}");
        }
        return $codes;
    }

    /**
     * Decode standard Base32 string to raw binary string
     */
    private function base32Decode(string $b32): string
    {
        $b32 = strtoupper(trim($b32));
        $buffer = 0;
        $bitsLeft = 0;
        $output = '';

        for ($i = 0, $len = strlen($b32); $i < $len; $i++) {
            $c = $b32[$i];
            $val = strpos(self::BASE32_CHARS, $c);
            if ($val === false) {
                continue;
            }

            $buffer = ($buffer << 5) | $val;
            $bitsLeft += 5;

            if ($bitsLeft >= 8) {
                $bitsLeft -= 8;
                $output .= chr(($buffer >> $bitsLeft) & 0xFF);
            }
        }

        return $output;
    }
}
