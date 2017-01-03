<?php
namespace Parking;
use Sunra\PhpSimple\HtmlDomParser;

class Load{

  public function bs($request, $response, $next){
    $arr = [];
    foreach(\simplexml_load_file("http://www.parkleitsystem-basel.ch/rss_feed.php")->channel->item as $item){
      $arr[] = [
        'name' => $item->title[0]->__toString(),
        'link' => $item->link[0]->__toString(),
        'frei' => intval(array_pop(explode(":",$item->description[0]->__toString())))
      ];
    }
    return $response->withJson($arr, 200);
  }

  public function zh($request, $response, $next){
    $arr = [];
    foreach(\simplexml_load_file("http://www.pls-zh.ch/plsFeed/rss")->channel->item as $item){
      $arr[] = [
        'name' => trim(explode("/", $item->title[0]->__toString())[0]),
        'link' => $item->link[0]->__toString(),
        'frei' => intval(array_pop(explode("/",$item->description[0]->__toString())))
      ];
    }
    return $response->withJson($arr, 200);
  }

  public function sg($request, $response, $next){
    $arr = [];
    foreach(\simplexml_load_file("http://www.pls-sg.ch/rss/")->channel->item as $item){
      $arr[] = [
        'name' => array_pop(explode(" ", trim($item->title[0]->__toString()))),
        'link' => str_replace("parkfeld", "parking", trim($item->link[0]->__toString())),
        'frei' => intval(explode(" ", trim($item->description[0]->__toString()))[0])
      ];
    }
    return $response->withJson($arr, 200);
  }

  public function lu($request, $response, $next){
    $arr = [];
    $html = HtmlDomParser::file_get_html('http://www.pls-luzern.ch/de/');
    foreach ($html->find('li[class=parking-station]') as $parking) {
      $arr[] = [
          "name" => trim($parking->find('span[class=name]')[0]->plaintext),
          "link" => (isset($parking->attr['data-link']))?$parking->attr['data-link']:"",
          "frei" => intval(trim($parking->find('div[class=free-spaces]')[0]->plaintext)),
      ];
    }
    return $response->withJson($arr, 200);
  }

  public function be($request, $response, $next){
    $arr = [];
    $html = HtmlDomParser::file_get_html('http://www.parking-bern.ch/d/index.php');
    foreach ($html->find('div[class=infotable]', 0)->find('div[class=row]') as $parking){
      if(!empty($parking->find('a[class=navlink]')[0]->plaintext)){
        $arr[] = [
           "name" => trim($parking->find('a[class=navlink]')[0]->plaintext),
           "link" => "http://www.parking-bern.ch/d/index.php".$parking->find('a[class=navlink]')[0]->href,
           "frei" => intval($parking->find('span[class=parkcount_good]')[0]->plaintext)
       ];
      }
    }
    return $response->withJson($arr, 200);
  }

  public function zg($request, $response, $next){
    $arr = [];
    foreach (json_decode(file_get_contents("http://www.pls-zug.ch/?json=true"))->content as $parking) {
      $arr[] = [
          "name" => $parking->name,
          "link" => "http://www.pls-zug.ch",
          "frei" => intval($parking->free)
      ];
    }
    return $response->withJson($arr, 200);
  }


}
