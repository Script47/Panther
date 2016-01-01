<?php

include_once('mods/globals.php');

/* QUICK AND DIRTY TEST MODULE */

if ( array_key_exists ( 'update', $_GET ) ) {

	//Update stats.
	//$user->setStats( array ( 'energy' => 21 ) );
	$HPstatName = $user->getStatName ( 1 );
	$BPstatName = $user->getStatName ( 2 );

	if ( $user->setStats ( array ( 
		'stat_1' => ( int ) $user->getStat ( $HPstatName ) + 10,
		'stat_2' => ( int ) $user->getStat ( $BPstatName ) + 10,
	) ) ) {
		echo '<p>Added 10 to '.$HPstatName.' and added 10 to '.$BPstatName.'</p>';
	} else {
		echo $db->error;
	}

}

if ( $getStats = $db->prepare ( 'SELECT stat_1, stat_2, stat_3, stat_4, stat_5 FROM users_stats WHERE ( uid = ? )' ) ) {
	$getStats->bind_param ( 'i', $_SESSION['uid'] );
	$getStats->execute();
	$getStats->store_result();
	if ( $getStats->num_rows() == 1 ) {
		$getStats->bind_result ( $stat1, $stat2, $stat3, $stat4, $stat5 );
		$getStats->fetch();
	}
	$getStats->free_result();
	$getStats->close();
}

if ( isset ( $stat1, $stat2, $stat3, $stat4, $stat5 ) ) {

	echo '<a href="?update" title="Update">Update</a>
	<ul>
		<li>HP: '.$stat1.'</li>
		<li>Backpack: '.$stat2.'</li>
		<li>Attack: '.$stat3.'</li>
		<li>Defend: '.$stat4.'</li>
		<li>Upgrade Points: '.$stat5.'</li>
	</ul>';

} else {
	echo $db->error;
}
