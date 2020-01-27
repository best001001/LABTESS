<?php
header("Content-type:application/json; charset=UTF-8");    
header("Cache-Control: no-store, no-cache, must-revalidate");         
header("Cache-Control: post-check=0, pre-check=0", false); 
    $accessToken = "0zv2kguUzxFpHl2hOa4GREeT2dhpx+Cr3yb/oHwA374LsKwDCldj/8DHjllLOlvWT7+m6gp46AyPTrHTLsf/R0khwzaoxqWnapg/5MI8iMxAio9Wefmx8lCEelzbDV2y57rnGdzHd4o6M204/4ioyAdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    $id = $arrayJson['events'][0]['source']['userId'];
    //รับข้อความจากผู้ใช้
    //$message = $arrayJson['events'][0]['message']['text'];
    $message = "flex";
#ตัวอย่าง Message Type "Text"
    if($message == "สวัสดี"){
        $arrayPostData = [
            'replyToken' =>  $arrayJson['events'][0]['replyToken'],
            'messages'   =>  [
                [
                'type' => 'text',
                'text' => 'สวัสดีนะ'
                ]
            ]
        ];
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Sticker"
    else if($message == "ฝันดี"){ 
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "sticker";
        $arrayPostData['messages'][0]['packageId'] = "2";
        $arrayPostData['messages'][0]['stickerId'] = "46";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Image"
    else if(strpos($message,"รูปน้องแมว") !== false){
        $image_url = "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg";
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "image";
        $arrayPostData['messages'][0]['originalContentUrl'] = $image_url;
        $arrayPostData['messages'][0]['previewImageUrl'] = $image_url;
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Location"
    else if($message == "พิกัดสยามพารากอน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "location";
        $arrayPostData['messages'][0]['title'] = "สยามพารากอน";
        $arrayPostData['messages'][0]['address'] =   "13.7465354,100.532752";
        $arrayPostData['messages'][0]['latitude'] = "13.7465354";
        $arrayPostData['messages'][0]['longitude'] = "100.532752";
        replyMsg($arrayHeader,$arrayPostData);
    }
    #ตัวอย่าง Message Type "Text + Sticker ใน 1 ครั้ง"
    else if($message == "ลาก่อน"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "อย่าทิ้งกันไป";
        $arrayPostData['messages'][1]['type'] = "sticker";
        $arrayPostData['messages'][1]['packageId'] = "1";
        $arrayPostData['messages'][1]['stickerId'] = "131";
        replyMsg($arrayHeader,$arrayPostData);
    }
    else if($message == "token"){
        $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $content;
        replyMsg($arrayHeader,$arrayPostData);
    }
    else if(stripos($message, 'gps') !== false ){
        list($gpsz,$car_id)=explode(" ",$message); 

        //if( mb_strlen($car_id, 'UTF-8') >= 3 && mb_strlen($car_id, 'UTF-8') <= 10){
          $gps = file_get_contents("https://640ea40e.ngrok.io/line-bot/eiei.php?car_id=".trim(str_replace(" ","",urlencode($car_id))));
          $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
          $arrayPostData['messages'][0]['type'] = "text";
          $arrayPostData['messages'][0]['text'] = $gps;
          replyMsg($arrayHeader,$arrayPostData);
        //}
    }

    else if($arrayJson['events'][0]['message']['type']=="location"){
        $arrayPostData = [
            'replyToken' =>  $arrayJson['events'][0]['replyToken'],
            'messages'   =>  [
                [
                'type' => 'text',
                'text' => 'เราได้รับ Location เรียบร้อยแล้ว'
                ]
            ]
        ];
        replyMsg($arrayHeader,$arrayPostData);

    }
    else if(stripos($message, 'dio') !== false){
      $arrayPostData = [
          'replyToken' =>  $arrayJson['events'][0]['replyToken'],
          'messages'   =>  [
              [
              'type'               => 'video',
              'originalContentUrl' => 'https://youtu.be/QmfOI8RaaUw',
              'previewImageUrl'    => 'https://i.kym-cdn.com/photos/images/original/000/809/392/d22.jpg'
              ]
          ]
      ];
      replyMsg($arrayHeader,$arrayPostData);
  }

  else if(stripos($message, 'flex') !== false){
    $a=[
      [
        "type"=> "flex",
        "altText"=> "Flex Message",
        "contents"=> [
          "type"=> "bubble",
          "hero"=> [
            "type"=> "image",
            "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png",
            "size"=> "full",
            "aspectRatio"=> "20=>13",
            "aspectMode"=> "cover",
            "action"=> [
              "type"=> "uri",
              "label"=> "Line",
              "uri"=> "https://linecorp.com/"
            ]
          ],
          "body"=> [
            "type"=> "box",
            "layout"=> "vertical",
            "contents"=> [
              [
                "type"=> "text",
                "text"=> "Brown Cafe",
                "size"=> "xl",
                "weight"=> "bold"
              ],
              [
                "type"=> "box",
                "layout"=> "baseline",
                "margin"=> "md",
                "contents"=> [
                  [
                    "type"=> "icon",
                    "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png",
                    "size"=> "sm"
                  ],
                  [
                    "type"=> "icon",
                    "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png",
                    "size"=> "sm"
                  ],
                  [
                    "type"=> "icon",
                    "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png",
                    "size"=> "sm"
                  ],
                  [
                    "type"=> "icon",
                    "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png",
                    "size"=> "sm"
                  ],
                  [
                    "type"=> "icon",
                    "url"=> "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png",
                    "size"=> "sm"
                  ],
                  [
                    "type"=> "text",
                    "text"=> "4.0",
                    "flex"=> 0,
                    "margin"=> "md",
                    "size"=> "sm",
                    "color"=> "#999999"
                  ]
                ]
              ],
              [
                "type"=> "box",
                "layout"=> "vertical",
                "spacing"=> "sm",
                "margin"=> "lg",
                "contents"=> [
                  [
                    "type"=> "box",
                    "layout"=> "baseline",
                    "spacing"=> "sm",
                    "contents"=> [
                      [
                        "type"=> "text",
                        "text"=> "Place",
                        "flex"=> 1,
                        "size"=> "sm",
                        "color"=> "#AAAAAA"
                      ],
                      [
                        "type"=> "text",
                        "text"=> "Miraina Tower, 4-1-6 Shinjuku, Tokyo",
                        "flex"=> 5,
                        "size"=> "sm",
                        "color"=> "#666666",
                        "wrap"=> true
                      ]
                    ]
                  ],
                  [
                    "type"=> "box",
                    "layout"=> "baseline",
                    "spacing"=> "sm",
                    "contents"=> [
                      [
                        "type"=> "text",
                        "text"=> "Time",
                        "flex"=> 1,
                        "size"=> "sm",
                        "color"=> "#AAAAAA"
                      ],
                      [
                        "type"=> "text",
                        "text"=> "10=>00 - 23=>00",
                        "flex"=> 5,
                        "size"=> "sm",
                        "color"=> "#666666",
                        "wrap"=> true
                      ]
                    ]
                  ]
                ]
              ]
            ]
          ],
          "footer"=> [
            "type"=> "box",
            "layout"=> "vertical",
            "flex"=> 0,
            "spacing"=> "sm",
            "contents"=> [
              [
                "type"=> "button",
                "action"=> [
                  "type"=> "uri",
                  "label"=> "CALL",
                  "uri"=> "https://linecorp.com"
                ],
                "height"=> "sm",
                "style"=> "link"
              ],
              [
                "type"=> "button",
                "action"=> [
                  "type"=> "uri",
                  "label"=> "WEBSITE",
                  "uri"=> "https://linecorp.com"
                ],
                "height"=> "sm",
                "style"=> "link"
              ],
              [
                "type"=> "spacer",
                "size"=> "sm"
              ]
            ]
          ]
        ]
      ]
    ];

    $b = [
      "type" => "flex",
      "altText" => "Hello Flex Message",
      "contents" => [
        "type" => "bubble",
        "direction" => "ltr",
        "header" => [
          "type" => "box",
          "layout" => "vertical",
          "contents" => [
            [
              "type" => "text",
              "text" => "Purchase",
              "size" => "lg",
              "align" => "start",
              "weight" => "bold",
              "color" => "#009813"
            ],
            [
              "type" => "text",
              "text" => "฿ 100.00",
              "size" => "3xl",
              "weight" => "bold",
              "color" => "#000000"
            ],
            [
              "type" => "text",
              "text" => "Rabbit Line Pay",
              "size" => "lg",
              "weight" => "bold",
              "color" => "#000000"
            ],
            [
              "type" => "text",
              "text" => "2019.02.14 21:47 (GMT+0700)",
              "size" => "xs",
              "color" => "#B2B2B2"
            ],
            [
              "type" => "text",
              "text" => "Payment complete.",
              "margin" => "lg",
              "size" => "lg",
              "color" => "#000000"
            ]
          ]
        ],
        "body" => [
          "type" => "box",
          "layout" => "vertical",
          "contents" => [
            [
              "type" => "separator",
              "color" => "#C3C3C3"
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "margin" => "lg",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "Merchant",
                  "align" => "start",
                  "color" => "#C3C3C3"
                ],
                [
                  "type" => "text",
                  "text" => "BTS 01",
                  "align" => "end",
                  "color" => "#000000"
                ]
              ]
            ],
            [
              "type" => "box",
              "layout" => "baseline",
              "margin" => "lg",
              "contents" => [
                [
                  "type" => "text",
                  "text" => "New balance",
                  "color" => "#C3C3C3"
                ],
                [
                  "type" => "text",
                  "text" => "฿ 45.57",
                  "align" => "end"
                ]
              ]
            ],
            [
              "type" => "separator",
              "margin" => "lg",
              "color" => "#C3C3C3"
            ]
          ]
        ],
        "footer" => [
          "type" => "box",
          "layout" => "horizontal",
          "contents" => [
            [
              "type" => "text",
              "text" => "View Details",
              "size" => "lg",
              "align" => "start",
              "color" => "#0084B6",
              "action" => [
                "type" => "uri",
                "label" => "View Details",
                "uri" => "https://google.co.th/"
              ]
            ]
          ]
        ]
      ]
    ];

    $c =[
      [
        "type" => "flex",
        "altText" => "Flex Message",
        "contents" => [
          "type" => "bubble",
          "direction" => "ltr",
          "body" => [
            "type" => "box",
            "layout" => "vertical",
            "contents" => [
              [
                "type" => "text",
                "text" => "Body",
                "align" => "center"
              ]
            ]
          ],
          "footer" => [
            "type" => "box",
            "layout" => "horizontal",
            "contents" => [
              [
                "type" => "button",
                "action" => [
                  "type" => "uri",
                  "label" => "Button",
                  "uri" => "https://linecorp.com"
                ]
              ]
            ]
          ]
        ]
      ]
    ];
    $arrayPostData = [
        'replyToken' =>  $arrayJson['events'][0]['replyToken'],
        'messages'   =>  [$c]
    ];
    replyMsg($arrayHeader,$arrayPostData);
}


    else{
        $a=[
            "type"=> "text", // ①
            "text"=> "คุณพิมไม่ถูกต้องสามารถลองแตะที่ปุ่ม 'Quick Reply' ของเราได้ ",
            "quickReply"=> [ // ②
              "items"=> [
                [
                  "type"=> "action", // ③
                  "imageUrl"=> "https://i.pinimg.com/originals/cc/22/d1/cc22d10d9096e70fe3dbe3be2630182b.jpg",
                  "action"=> [
                    "type"=> "message",
                    "label"=> "ขอรูปน้องแมว",
                    "text"=> "รูปน้องแมว"
                  ]
                ],
                [
                  "type"=> "action",
                  "imageUrl"=> "",
                  "action"=> [
                    "type"=> "message",
                    "label"=> "ฝันดีบอท",
                    "text"=> "ฝันดี"
                  ]
                ],
                [
                  "type"=> "action", // ④
                  "action"=> [
                    "type"=> "location",
                    "label"=> "Send location"
                  ]
                ]
              ]
            ]
          ];
        $arrayPostData = [
            'replyToken' =>  $arrayJson['events'][0]['replyToken'],
            'messages' => [$a]
        ];
        replyMsg($arrayHeader,$arrayPostData);
    }
    
function replyMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/reply";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }

function pushMsg($arrayHeader,$arrayPostData){
        $strUrl = "https://api.line.me/v2/bot/message/push";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$strUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close ($ch);
    }    
   exit;
?>
