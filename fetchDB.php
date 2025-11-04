<?php 
	$operation_type = $_POST["operation"];
	$selected_table = $_POST["table"];

	$connect_data = "host=localhost port=5433 dbname=postgres user=postgres password=";
	$db_connect = pg_connect($connect_data);

	if (!$db_connect) {
	    die("Ошибка подключения: " . pg_result_error());
	}
	$html = "";

	switch ($operation_type)
	{
		case "show":
			$query = pg_query($db_connect, "SELECT * FROM $selected_table");
			if (!$query) {
			        die ("Ошибка выполнения запроса");
			}

			switch($selected_table)
			{
				case "Ingredients":
					$html = $html . "<p> id. type | cost (rub) | recipe used </p>";
					while ($result = pg_fetch_array($query)) {
			     		$html = $html . "<p>{$result['id_ingredient']}. - {$result['type']} - {$result['cost_rub']} - {$result['recipe_used']}</p> ";
					}
					break;
				case "Recipes":
					$html = $html . "<p> id. title | difficulty | minutes to cook </p>";
					while ($result = pg_fetch_array($query)) {
			     		$html = $html . "<p>{$result['id_recipe']}. {$result['title']} - {$result['difficulty']} - {$result['minutes_to_cook']}</p> ";
					}
					break;
				case 'Steps':
					$html = $html . "<p> id. title | recipe used | description | ingridient used | number of step </p>";
					while ($result = pg_fetch_array($query)) {
			     		$html = $html . "<p>{$result['id_step']}. {$result['title']} - {$result['recipe_used']} - {$result['description']} - {$result['ingridient_used']} руб. - {$result['number_of_step']}</p> ";
					}
					break;
				case 'Technologies':
					$html = $html . "<p> id. name | step |origin | skills_required (true/false) </p>";
					while ($result = pg_fetch_array($query)) {
			     		$html = $html . "<p>{$result['id_technology']}. {$result['name']} - {$result['step']} - {$result['origin']}</p> ";
					}			
			}
			break;
		case "change":
			$field = $_POST["field"];
			$new_value = $_POST["value"];
			$id = $_POST["id"];
			switch($selected_table)
			{
				case "technologies":
					$query = pg_query($db_connect, "UPDATE technologies SET $field = '$new_value' where id_technology = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное редактирование";
					break;
				case "Ingredients":
					$query = pg_query($db_connect, "UPDATE Ingredients SET $field = '$new_value' where id_ingredient = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное редактирование";
					break;
				case 'Steps':
					$query = pg_query($db_connect, "UPDATE Steps SET $field = '$new_value' where id_step = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное редактирование";
					break;
				case 'Recipes':
				$query = pg_query($db_connect, "UPDATE Recipes SET $field = '$new_value' where id_recipe = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное редактирование";
					break;			
			}
			break;
		case "delete":
		$id = $_POST["id"];	
		switch($selected_table)
			{
			case "Technologies":
					$query = pg_query($db_connect, "DELETE from Technologies where id_technology = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное удаление";
					break;
				case "Ingredients":
					$query = pg_query($db_connect, "DELETE from Ingredients where id_ingredient = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное удаление";
					break;
				case 'Steps':
					$query = pg_query($db_connect, "DELETE from Steps where id_step = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное удаление";
					break;
				case 'Recipes':
				$query = pg_query($db_connect, "DELETE from Recipes where id_recipe = $id");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное удаление";
					break;
				}
			break;
		case "insert":
			$data = json_decode(stripslashes($_POST['data']));
			switch($selected_table)
			{
			case "technologies":
					$query = pg_query($db_connect, "insert into technologies(name, step, origin, skills_required) values ('$data[0]', '$data[1]', '$data[2]', '$data[3]')");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное добавление";
					break;
				case "Ingredients":
					$query = pg_query($db_connect, "insert into Ingredients (type, cost_rub, recipe_used) values ('$data[0]', '$data[1]', $data[2], '$data[3]')");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное добавление";
					break;
				case 'Steps':
					$query = pg_query($db_connect, "insert into Steps (title, recipe_used, description, ingridient_used, number_of_step) values ('$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]')");
					if (!$query) {
			        die ("Ошибка выполнения запроса");
			       		echo "Ошибка";
						}
					$html = "Успешное добавление";
					break;
				case 'Recipes':
				$query = pg_query($db_connect, "insert into Recipes (title, difficulty, minutes_to_cook) values ('$data[0]', '$data[1]', '$data[2]')");
					if (!$query) {
			        die ("Ошибка выполнения запроса");

			       		echo "Ошибка";
						}
					$html = "Успешное добавление";
					break;
			}
			break;
			case 'query1':
				$query = pg_query($db_connect, "SELECT title, difficulty, minutes_to_cook FROM recipes");
				if (!$query) {
			        die ("Ошибка выполнения запроса");
				}
				$html = $html . "<p> title | difficulty | minutes to cook </p>";
				while ($result = pg_fetch_array($query)) {
		     		$html = $html . "<p>{$result['title']} - {$result['difficulty']}- {$result['minutes_to_cook']}</p> ";
				}
				break;
			case 'query2':
				$query = pg_query($db_connect, "SELECT i.type, i.cost_rub FROM ingredients i JOIN steps s ON i.id_ingredient = s.ingridient_used JOIN recipes r ON s.recipe_used = r.id_recipe WHERE r.difficulty = (SELECT MAX(difficulty) FROM recipes);");
				if (!$query) {
			        die ("Ошибка выполнения запроса");
				}
				$html = $html . "<p> type | cost (rub)  </p>";
				while ($result = pg_fetch_array($query)) {
		     		$html = $html . "<p>{$result['type']} - {$result['cost_rub']}</p> ";
				}
				break;
			case 'query3':
				$query = pg_query($db_connect, "SELECT r.title, COUNT(s.id_step) AS num_steps FROM recipes r JOIN steps s ON r.id_recipe = s.recipe_used GROUP BY r.title;");
				if (!$query) {
			        die ("Ошибка выполнения запроса");
				}
				$html = $html . "<p> title | steps number </p>";
				while ($result = pg_fetch_array($query)) {
		     		$html = $html . "<p>{$result['title']} - {$result['num_steps']}</p> ";
				}
				break;
			case 'query4':
				$query = pg_query($db_connect, "SELECT s.title, t.name FROM steps s JOIN technologies t ON s.id_step = t.step JOIN recipes r ON s.recipe_used = r.id_recipe WHERE r.title = 'Пицца' AND t.skills_required = true;");
				if (!$query) {
			        die ("Ошибка выполнения запроса");
				}
				$html = $html . "<p> title | name </p>";
				while ($result = pg_fetch_array($query)) {
		     		$html = $html . "<p>{$result['title']} - {$result['name']}</p> ";
				}
				break;
			case 'query5':
				$query = pg_query($db_connect, "SELECT r.title, AVG(i.cost_rub) AS avg_cost FROM recipes r JOIN steps s ON r.id_recipe = s.recipe_used JOIN ingredients i ON s.ingridient_used = i.id_ingredient GROUP BY r.title;");
				if (!$query) {
			        die ("Ошибка выполнения запроса");
				}
				$html = $html . "<p> title | avg cost </p>";
				while ($result = pg_fetch_array($query)) {
		     		$html = $html . "<p>{$result['title']} - {$result['avg_cost']}</p> ";
				}
				break;
	}
	echo $html;
 ?>