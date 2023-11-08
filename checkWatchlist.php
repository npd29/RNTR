<?php
foreach ($pdo->query("SELECT tblWatchlist.fldSendEmail, tblUsers.fldEmail FROM tblWatchlist WHERE fkAptID=='$aptID' INNER JOIN tblUsers ON tblWatchlist.fkUsername=tblUsers.pmkUsername") as $item){
    if($item['tblWatchlist.fldSendEmail']){
        $to = $item['tblUsers.fldEmail'];
        $from = 'The RNTR Team <noel@rntr.org>';
        $subject = "RNTR - An apartment you're watching has been updated";

        $mailMessage ='<div style="background-color: white"><p style="font-family: Montserrat, sans-serif; color:var(--purple)">This is a test</p> <p>-The RNTR Team</p></div>';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: " . $from . "\r\n";

        $mailSent = mail($to, $subject, $mailMessage, $headers);
    }
}
                        //TODO: then check watchlist for that AptID and if fldSendEmail send an email to fldEmail
                        //TODO: add address to watchlist table. if aptid for that address already exists then add it
                        //TODO: when a new apt gets added check the watchlist table to see if anyone is looking for it, if they are then add the aptid and send email