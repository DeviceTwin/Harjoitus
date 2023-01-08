<?php
header('Content-Type: application/json');
$uri = $_SERVER['REQUEST_URI'];
# Default is Not Found
$status = 404;

# Supported shape types
# Add new shape type in the end of this list and
# calculate code in if else statement
$calculateCircle = "circle";
$calculateSquare = "square";
$calculateRectangle = "rectangle";

# Calculate Circle area
if (strpos($uri, $calculateCircle) !== false) {
	
	$radiusArray = (explode("/", getenv('REQUEST_URI')));
	$radius = $radiusArray[4];
	
	# If radius is empty then error notification
	if ((float)$radius == 0) {
		$status = 400;
		$result = array("status" => "Bad Request",
						"description" => "Radius is missing or it is not ok");
	}
	
	# Calculate Circle area
	else {
		(float)$area = ((float)$radius * (float)$radius) * pi();
		(float)$area = round((float)$area, 2);
		$status = 200;
		$result = array("Area" => (float)$area, 
						"Shape type" => "Circle",
						"Radius" => (float)$radius);
	}
}

# Calculate Square area
elseif (strpos($uri, $calculateSquare) !== false) {
	if (isset($_GET['side'])) {
		$side = $_GET['side'];
		
		# If side value is missing then error notification
		if ((float)$side == 0) {
			$status = 400;
			$result = array("status" => "Bad Request",
							"description" => "Side value is missing or it is not ok");
		}
		
		# Calculate Square area
		else {
			(float)$area = (float)$side * (float)$side;
			(float)$area = round((float)$area, 2);
			$status = 200;
			$result = array("Area" => (float)$area,
							"Shape type" => "Square",
							"Side length" => (float)$side);
		}
	}
	
	# If side parameter is missing then send error notification
	else {
		$status = 400;
		$result = array("status" => "Bad Request",
						"description" => "Side parameter missing");
	}
}

# Calculate Rectangle area
elseif (strpos($uri, $calculateRectangle) !== false) {
	$json = file_get_contents('php://input');
	$data = json_decode($json);
	$side1 = $data->side1;
	$side2 = $data->side2;
	
	# If Side 1 or Side 2 are missing then send notification
	if (((float)$side1 == 0) || ((float)$side2 == 0)) {
		$status = 400;
		$result = array("status" => "Bad Request",
						"description" => "Side one or Side two are missing or not ok");
	}
	
	# Calculate Rectangle area
	else {
		(float)$area = (float)$side1 * (float)$side2;
		(float)$area = round((float)$area, 2);
		$status = 200;
		$result = array("Area" => (float)$area,
						"Shape type" => "Rectangle",
						"Side one" => (float)$side1,
						"Side two" => (float)$side2);
	}
}

# Given shape is not support
else {
	$status = 404;
	$result = array("status" => "Not Found",
					"description" => "Given shape is misspelling or it is not supported");
}

# JSON type output, where
# Area, Shape type, Given parameters
#
# If error, then
# status is fault and error description
header("HTTP/1.1 ".$status);
echo json_encode($result);

?>
