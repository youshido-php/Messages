# Youshido Messages Bundle

``` php
$user = $this->get('doctrine')->getRepository('AppBundle:User')
            ->find(1);

$user2 = $this->get('doctrine')->getRepository('AppBundle:User')
    ->find(2);
    
$user3 = $this->get('doctrine')->getRepository('AppBundle:User')
    ->find(3);

$conversations = $this->get('messages')->getConversations($user);
$newMessages = $this->get('messages')->countUnreadMessages($user);

$conversation = $this->get('doctrine')
    ->getRepository('YMessagesBundle:Conversation')
    ->find(1);

//only get messages
$messages = $this->get('messages')->getMessages($conversation->getId());
//get messages and set it to read for user
$messages = $this->get('messages')->getMessages($conversation->getId(), $user);


//sending new message
$this->get('messages')->sendMessage($conversation->getId(), $user, 'hello !');

$this->get('messages')->joinConversation($conversation->getId(), $user2);
$this->get('messages')->leaveConversation($conversation->getId(), $user2);

$members = $this->get('messages')->getMembers($conversation->getId());

$conversation = $this->get('messages')->findOrCreateConversation($user2, $user3);

$is = $this->get('messages')->isConversationBetween($user, $user2);
```