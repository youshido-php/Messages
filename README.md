# Youshido Messages Bundle

``` php
$user = $this->get('doctrine')->getRepository('AppBundle:User')
    ->find(1);

$user2 = $this->get('doctrine')->getRepository('AppBundle:User')
    ->find(1);

$rooms = $this->get('messages')->getRooms($user);
$newMessages = $this->get('messages')->countUnreadMessages($user);

$room = $this->get('doctrine')
    ->getRepository('YMessagesBundle:Room')
    ->find(1);

$messages = $this->get('messages')->getMessages($room->getId()); //only get messages
$messages = $this->get('messages')->getMessages($room->getId(), $user); //get messages and set it to read for user

//sending new message
$this->get('messages')->sendMessage($room->getId(), $user, 'hellow !');

$this->get('messages')->joinRoom($room->getId(), $user2);
$this->get('messages')->leaveRoom($room->getId(), $user2);

$members = $this->get('messages')->getMembers($room->getId());
```