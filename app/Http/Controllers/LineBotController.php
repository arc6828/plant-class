<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use LINE\LINEBot;
// use LINE\LINEBot\HTTPClient\CurlHTTPClient;
// use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
// use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use Illuminate\Support\Facades\Http;
use LINE\Clients\MessagingApi\Model\ReplyMessageRequest;
use LINE\Clients\MessagingApi\Model\TextMessage;

class LineBotController extends Controller
{
    private $bot;
    private $messagingApi;
    private $messagingApiBlob;

    public function __construct()
    {
        // $httpClient = new CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
        // $this->bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);
        $client = new \GuzzleHttp\Client();
        $config = new \LINE\Clients\MessagingApi\Configuration();
        $config->setAccessToken(env('LINE_CHANNEL_ACCESS_TOKEN'));
        $this->messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
            client: $client,
            config: $config,
        );
        $this->messagingApiBlob = new \LINE\Clients\MessagingApi\Api\MessagingApiBlobApi(
            client: $client,
            config: $config,
        );
    }

    public function webhook(Request $request)
    {
        $events = $request->events;
        foreach ($events as $event) {
            // ตรวจสอบว่ามีการส่งรูปภาพหรือไม่
            if ($event['message']['type'] == 'image') {
                // รับ image ID จาก LINE
                $imageId = $event['message']['id'];
                // $response = $this->bot->getMessageContent($imageId);
                $response = $this->messagingApiBlob->getMessageContent($imageId);

                // if ($response->isSucceeded()) {
                if ($response->isFile()) {
                    // $imageData = $response->getRawBody();
                    $imagePath = $response->getPathname();


                    $result = $this->classifyPlant($response); // เรียกใช้ฟังก์ชันจำแนกพืช
                    $message = new TextMessage(['type' => 'text', 'text' => $result]);
                    $request = new ReplyMessageRequest([
                        'replyToken' => $event['replyToken'],
                        'messages' => [$message],
                    ]);
                    $response = $this->messagingApi->replyMessage($request);
                    // $imageData = $response->getRawBody();

                    // $replyToken = $event['replyToken'];
                    // $textMessage = new TextMessage($result);
                    // $this->bot->replyMessage($replyToken, $textMessage);
                }
            } else {
                $message = new TextMessage(['type' => 'text', 'text' => 'hello! non image']);
                $request = new ReplyMessageRequest([
                    'replyToken' => $event['replyToken'],
                    'messages' => [$message],
                ]);
                $response = $this->messagingApi->replyMessage($request);
                // ตอบกลับเมื่อไม่ได้ส่งรูปภาพ
                // $replyToken = $event['replyToken'];
                // $message = "กรุณาส่งภาพพืชที่ต้องการจำแนก";
                // $textMessage = new TextMessageBuilder($message);
                // $this->bot->replyMessage($replyToken, $textMessage);
            }
        }
    }



    private function classifyPlant($image)
    {
        $imagePath = $image->getPathname();

        // URL ของ PlantNet API พร้อมคีย์ API
        $apiKey = env('PLANTNET_API_KEY');
        $apiUrl = "https://my-api.plantnet.org/v2/identify/all?api-key=$apiKey&include-related-images=true&nb-results=3";

        // ส่งคำขอไปยัง PlantNet API
        $response = Http::attach(
            'images',
            file_get_contents($imagePath),
            // 'plant.jpg'
            // $image->
            $image->getFilename()
        )->post($apiUrl, [
            'organs' => 'leaf',
        ]);

        // ตรวจสอบผลลัพธ์และแสดงชื่อพืช
        if ($response->successful()) {
            $result = $response->json();            
            return $this->view($result);
        } else {
            return 'เกิดข้อผิดพลาดในการเชื่อมต่อกับ PlantNet API';
        }
    }

    private function view($result)
    {
        
        $plantInfo = "จำแนกพืชด้วยภาพ \nลำดับ ชื่อ (คะแนน)\n";
        foreach ($result['results'] as $key=>$plant) {
            $scientificName = $plant['species']['scientificName'];
            $commonName = $plant['species']['commonNames'][0] ?? 'N/A';
            $score = round($plant['score'] * 100, 0);
            $plantInfo .= "".($key+1).". ";
            $plantInfo .= "$commonName ($score%) \n";
        }
        $plantInfo .= "---";
        return $plantInfo ?: 'ไม่สามารถจำแนกพืชได้';
    }
}
