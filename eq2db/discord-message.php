<?PHP

if(!isset($argv[1])) {
    //if no args print options.
    echo ("\nYou must provide the following options to continue:\n");
    echo ("\nexample : discord-message.php <username> <message> <title> <service> <webhook>");
    echo ("\nUsername: Who to send the message as.");
    echo ("\nTitle   : The title for the message.");
    echo ("\nMessage : Message to send to discord.");
    echo ("\nService : The Service that has been updated.");
    echo ("\nWebhook : Webhook used to send the message.");
    echo ("\nMulti word entries must have quotes IE discord-message.php testuser \"Go away noob\" \"Updating Something\" Webeditor \"https://whatever.whatever\"\n");
    return;
} else {
    $username = $argv[1];
}

if(!isset($argv[2])) {
    echo("\nYou must provide a message to send to discord\n");
    return;
} else {
    $message = $argv[2];
}

if(!isset($argv[3])) {
    echo ("\nYou must provide a title to send to discord\n");
    return;
} else {
    $title = $argv[3];
}

if(!isset($argv[4])) {
    echo ("\nYou must provide a service to send to discord\n");
    return;
} else {
    $service = $argv[4];
}

if(!isset($argv[5])) {
    echo ("\nYou must provide a webhook to send to discord\n");
    return;
} else {
    $webhook = $argv[5];
}

function discordmsg($msg, $webhook) {
  if($webhook != "") {
    $ch = curl_init($webhook);
    $msg = "payload_json=" . urlencode(json_encode($msg))."";

    if(isset($ch)) {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }
  }
}

$msg = json_decode('
{
    "username":"DefaultUser",
        "embeds": [{
        "title":"[ Default Title. ]",
        "url":"https://www.eq2emu.com/",
        "description": "Default Message.",
        "color": "13369395",
            "author":{
            "name":"DefaultService",
            "url":"https://www.eq2emu.com/",
            "icon_url":"https://www.zeklabs.com/hal_9000-small.png"
        }
    }]
}
', true);

//username
$msg['username'] = $username;
//title
$msg['embeds']['0']['title'] = $title;
//description
$msg['embeds']['0']['description'] = $message;
//service
$msg['embeds']['0']['author']['name'] = $service;

discordmsg($msg, $webhook); // SENDS MESSAGE TO DISCORD
echo("\n[ Sending Message to Discord. ]\n");
return;

?>