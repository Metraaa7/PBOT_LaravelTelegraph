<?php

namespace App\Telegram;



use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Telegram\Bot\Api;


class Handler extends WebhookHandler
{

    public function start(): void {
        Telegraph::chat($this->chat->chat_id)->message("Access functions of bot: \n /gif - Send hot gifs \n /video - Send links to the hottest porn videos")->send();
    }

    public function gif() {
        $ths = (string) rand(1, 5);
        $huns = (string) rand(1, 9);
        $uns = (string) rand(1, 99);
        $rand = $ths . $huns . $uns;
        $url = "http://mob.porno365.bond/uploads/gifs/$ths/$huns/$rand/1.gif";

        Telegraph::chat($this->chat->chat_id)->animation($url)->send();
    }

    public function video()
    {
        $client = new Client();

        $response = $client->get('http://mob.porno365.bond/random');

        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);

        $metaTag = $crawler->filter('meta[property="og:video"]')->first();
        $metaPreview = $crawler->filter('meta[property="og:image"]')->first();

        $metaContent = $metaTag->attr('content');
        $metaImage = $metaPreview->attr('content');

        Telegraph::chat($this->chat->chat_id)->message('Since the maximum video length is 1 minute, I’d rather post a link to the video that you can watch ' . $metaContent)->photo($metaImage)->send();
    }
}