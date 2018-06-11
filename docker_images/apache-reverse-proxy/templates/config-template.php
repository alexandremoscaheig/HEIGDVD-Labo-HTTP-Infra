<?php
	$staticApp = explode(',', getenv('STATIC_APP'));
	$dynamicApp = explode(',', getenv('DYNAMIC_APP'));
?>

<VirtualHost *:80>
	ServerName demo.res.ch
	
	<Proxy "balancer://dynamicCluster">
		<?php
			foreach($dynamicApp as $ip) {
				print "BalancerMember 'http://$ip'\r\n";
			}
		?>
	</Proxy>

	<Proxy "balancer://staticCluster">
		<?php
			$i =  0;
			foreach($staticApp as $ip) {
				print "BalancerMember 'http://$ip/' route=$i\r\n";
				$i++;
			}
		?>
		 ProxySet stickysession=ROUTEID
	</Proxy>

	ProxyPass "/api/animals/" "balancer://dynamicCluster/"
	ProxyPassReverse "/api/animals/" "balancer://dynamicCluster/"

	Header add Set-Cookie "ROUTEID=.%{BALANCER_WORKER_ROUTE}e; path=/" env=BALANCER_ROUTE_CHANGED
	ProxyPass "/" "balancer://staticCluster/" 
	ProxyPassReverse "/" "balancer://staticCluster/"



</VirtualHost>
