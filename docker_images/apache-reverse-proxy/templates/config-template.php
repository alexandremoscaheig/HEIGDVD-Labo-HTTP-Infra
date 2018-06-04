<?php
	$staticApp = explode(',', getenv('STATIC_APP'));
	$dynamicApp = explode(',', getenv('DYNAMIC_APP'));
?>

<VirtualHost *:80>
	ServerName demo.res.ch

	<Proxy "balancer://dynamicCluster">
		<?php
			foreach($staticApp as $ip) {
				print "BalancerMember '$ip'";
			}
		?>
	</Proxy>

	<Proxy "balancer://staticCluster">
		<?php
			foreach($staticApp as $ip) {
				print "BalancerMember '$ip'";
			}
		?>
	</Proxy>

	ProxyPass "/api/animals/" "balancer://dynamicCluster"
	ProxyPassReverse "/api/animals/" "balancer://dynamicCluster"

	ProxyPass "/" "balancer://staticCluster"
	ProxyPassReverse "/" "balancer://staticCluster"


</VirtualHost>
