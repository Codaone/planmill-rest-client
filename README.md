# Planmill Rest client
Planmill rest api client for api version 1.0

````php
<?php
$api = new codaone\Planmill\Api(
    "https://online.planmill.com/[yourcompany]/",
    new codaone\Planmill\Api\Authentication\Basic("userid", "apikey")
);

$projects = $api->getProjects();
$tasks = $api->getTasks($projects[0]->getId());
````

# License

MIT License

# Planmill Rest API Documentation

http://wiki.planmill.com/display/HELPEN/PlanMill+REST+API
