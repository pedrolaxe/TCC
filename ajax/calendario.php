<?php
if(!isset($_SESSION['usuario_admin']))
{
	session_start();
}
include "../verifica.php";

/*
while ($record = mysql_fetch_array($result)) {
        $event_array[] = array(
            'id' => $record['id'],
            'title' => $record['title'],
            'start' => $record['start_date'],
            'end' => $record['end_date'],
            'allDay' => false
        );
    }
*/
$event_array[] = array(
            'id' => 1,
            'title' => 'evento',
            'start' => time(),
            'end' => time()+100,
            'allDay' => false
        );
echo json_encode($event_array);
