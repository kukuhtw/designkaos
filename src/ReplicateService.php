<?php
// src/ReplicateService.php
/**
 * ReplicateService.php
 * Handles calls to Replicate API
 */


/*
 * 
 * 🛠️ Aplikasi Desain Kaos AI
 * Dibuat oleh: Kukuh TW
 *
 * 📧 Email     : kukuhtw@gmail.com
 * 📱 WhatsApp  : 628129893706
 * 📷 Instagram : @kukuhtw
 * 🐦 X / Twitter: @kukuhtw
 * 👍 Facebook  : https://www.facebook.com/kukuhtw
 * 💼 LinkedIn  : https://id.linkedin.com/in/kukuhtw

*/


class ReplicateService
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }


    
    /**
     * Create a new prediction
     */
    public function generate(string $input1, string $input2, string $prompt): array
    {
        $url = 'https://api.replicate.com/v1/predictions';
        $data = [
            'version' => 'flux-kontext-apps/multi-image-kontext-max',
            'input'   => [
                'prompt'       => $prompt,
                'aspect_ratio' => '1:1',
                'input_image_1'=> $input1,
                'input_image_2'=> $input2,
            ],
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Token {$this->token}",
            'Content-Type: application/json',
            'Prefer: wait',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $resp = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($resp, true);
        if (isset($result['error'])) {
            throw new RuntimeException('Replicate error: ' . $result['error']);
        }
        return $result;
    }

    /**
     * Fetch prediction result (polling)
     */
    public function getResult(string $predictionId, int $retries = 10, int $delay = 8): array
    {
        $url = "https://api.replicate.com/v1/predictions/{$predictionId}";
        for ($i = 0; $i < $retries; $i++) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Token {$this->token}",
                'Content-Type: application/json',
            ]);
            $resp = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($resp, true);
            if (!empty($data['output'])) {
                return $data;
            }
            sleep($delay);
        }
        throw new RuntimeException('Image not ready after retries');
    }

    /**
     * Generate a prediction and wait until output is ready
     * @throws RuntimeException
     */
    public function generateAndWait(
        string $input1,
        string $input2,
        string $prompt,
        int $retries = 3,
        int $delay = 8
    ): array {
        // create prediction
        $prediction = $this->generate($input1, $input2, $prompt);
        $id = $prediction['id'];
        Logger::info("ReplicateService: Started prediction {$id}");

        // poll for result
        $url = "https://api.replicate.com/v1/predictions/{$id}";
        for ($i = 0; $i < $retries; $i++) {
            Logger::debug("ReplicateService: Polling attempt {$i} for id:{$id}");
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Token {$this->token}",
                'Content-Type: application/json',
            ]);
            $resp = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($resp, true);
            if (!empty($data['output'])) {
                Logger::info("ReplicateService: Output ready for {$id}");
                return $data;
            }
            sleep($delay);
        }
        throw new RuntimeException("Image not ready after {$retries} retries. Check REPLICATE API TOKEN or Timeout Server Connecting");
    }
}
?>
