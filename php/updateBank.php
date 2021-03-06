<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sistema Generador Aleatorio de Exámenes Parciales</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<script type="text/javascript" src="../js/script.js"></script>
	</head>
	<body>
		<header>
			<div id="dHeader">
				<img src="../Images/logo.png" alt="unam.png"/>
			</div>
			<nav>
				<div id="dNav">
					<li>
						<ul><a href="createBank.php">Crear Banco</a></ul>
						<ul><a href="updateBank.php">Actualizar Banco</a></ul>
						<ul><a href="consultBank.php">Consultar Banco</a></ul>
						<ul><a href="createExam.php">Crear Exámen</a></ul>
						<ul><a href="teacherConsultManual.php">Consultar Manual</a></ul>
						<ul><a href="teacherFaq.php">FAQ</a></ul>
						<ul><a href="../index.php">Salir</a></ul>
					</li>
				</div>
			</nav>
		</header>
		<section>

			<!--Section to show the subject-->
			<div id="moduleConsultSubject">
				<table id="tableShowSubjectsAJAX">
					<td><th>Seleccionar Materia a Actualizar</th></td>
					<tr>
						<td><label>Materia</label></td>
						<td>
							<select name="formConsultSubjectToCheck" id="formConsultSubjectToCheck" onchange="showSubject(this.value)">
								<option value="">Seleccione Materia</option>
								<?php
									//ACCESS TO DATABASE
									session_start();
									$link = mysql_connect('localhost', 'root', 'dwarfest')
    								or die('No se pudo conectar: ' . mysql_error());
									mysql_select_db('sgaep') or die('No se pudo seleccionar la base de datos');
									//READ DATABASE
									$results = mysql_query("SELECT * FROM tableSubjects WHERE vcRFC='".$_SESSION["vcRFC"]."'");
									while ($row = mysql_fetch_array($results)) {
										echo "<option value='".$row["vcIdSubject"]."'>".$row["vcSubjectName"]."</option>";
									}
								?>
							</select>
						</td>
					</tr>
				</table><br/>
				<!--AJAX Section, get the values of the Subject-->
				<div id="txtHint" class=""></div>
				<!--AJAX Section, get the values of the Subject-->
			</div>
			<!--Section to show the subject-->

			<!--Module to add questions to subject-->
			<div class="addQuestionToSubject" id="addQuestionToSubject" style="display: none;">


			<div id="moduleConsultSubjectQuestions">
				<table id="tableDeleteUsers">
						<tr>
							<th>Tipo de Pregunta</th>
						</tr>
						<tr>
							<td>
								<select class="selectQuestionType" name="selectQuestionType" onchange="showQuestionType(this.value)">
									<option value="">Seleccione Opción</option>
									<option value="booleanQuestion">Verdadero o Falso</option>
									<option value="multipleOptions">Opción Múltiple</option>
									<option value="openQuestion">Pregunta Abierta</option>
								</select>
							</td>
							<!--Hidding-->
						</tr>
				</table>
				<!--editing this section-->
				<div class="hideTypeOpen" id="hideTypeOpen" style="display: none;">
					<!--Form to send only open question to DB-->
					<form class="formOpenQuestion" id="formOpenQuestion" action="ajaxSendQuestionDB.php" method="post">
						<table>
							<thead>
								<th>Parcial</th>
								<th>Pregunta</th>
								<th>Respuesta</th>
							</thead>
							<tbody>
								<tr>
									<td>
										<select name="formUpdateQuestionBankPartial" id="formUpdateQuestionBankPartial" >
											<option value="1">1er</option>
											<option value="2">2do</option>
										</select>
									</td>
									<td>
										<input type="text" name="formUpdateQuestionBankQuestion" id="formUpdateQuestionBankQuestion" required="required">
									</td>
									<td>
										<input type="text" name="textInputAnswerOpen" id="textInputAnswerOpen" required="required"/>
									</td>
									<td>
										<input type="submit" value="Enviar Pregunta" id="buttonSubmitOpenQuestion">
									</td>
									<td>
										<input type="text" name="textInputQuestionID" id="textInputQuestionID" style="display: none;"/>
										<input type="text" name="textInputSubjectID" id="textInputSubjectID" style="display: none;"/>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
					<!--Form to send only open question to DB-->
				</div>
				<div class="hideTypeBoolean" id="hideTypeBoolean" style="display: none;">
					<form class="formAddBooleanQuestion" id="formAddBooleanQuestion" action="phpAddBooleanQuestion.php" method="post">
						<table class="tableBooleanQuestion" id="tableBooleanQuestion">
							<thead>
								<th>Parcial</th>
								<th>Pregunta</th>
								<th>Respuesta</th>
							</thead>
							<tbody>
								<tr>
									<td>
										<select name="formUpdateQuestionBankPartial" id="formUpdateQuestionBankPartial" >
											<option value="1">1er</option>
											<option value="2">2do</option>
										</select>
									</td>
									<td>
										<input type="text" name="formUpdateBooleanQuestionBankQuestion" id="formUpdateBooleanQuestionBankQuestion" required="required">
									</td>
									<td>
										<select name="formUpdateBooleanQuestionBankAnswer" id="formUpdateBooleanQuestionBankAnswer" >
											<option value="1">Verdadero</option>
											<option value="0">Falso</option>
										</select>
									</td>
									<td>
										<input type="submit" name="buttonAddBooleanQuestion" value="Enviar Pregunta">
									</td>
									<td>
										<input type="text" name="textBooleanInputQuestionID" id="textBooleanInputQuestionID" style="display: none;"/><!--style="display: none;"-->
										<input type="text" name="textBooleanInputSubjectID" id="textBooleanInputSubjectID" style="display: none;"/>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
				<!--Section for multiple questions-->

				<!--DEveloping this section for Multiple-->

				<div class="hydeTypeMultiple" id="hydeTypeMultiple" style="display: none;">
					<form class="formMultipleQuestion" action="phpAddMultpleQuestion.php" id="formMultipleQuestion" method="post">
						<table>
							<thead>
								<tr>
									<th>Parcial</th>
									<th>Pregunta</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<select name="formUpdateMultipleQuestionBankPartial" id="formUpdateMultipleQuestionBankPartial" >
											<option value="1">1er</option>
											<option value="2">2do</option>
										</select>
									</td>
									<td>
										<input type="text" name="formUpdateMultipleQuestionBankQuestion" id="formUpdateMultipleQuestionBankQuestion" required="required">
									</td>
								</tr>
							</tbody>
						</table>
						<table>
							<thead>
								<th>Agregar Respuestas</th>
							</thead>
							<tbody>
								<tr>
									<td>A<input type="text" name="inputTextMultipleOptionA" id="inputTextMultipleOptionA" required="required"/></td>
									<td>B<input type="text" name="inputTextMultipleOptionB" id="inputTextMultipleOptionB" required="required"/></td>
									<td>Respuesta Correcta</td>
								</tr>
								<tr>
									<td>C<input type="text" name="inputTextMultipleOptionC" id="inputTextMultipleOptionC" required="required"/></td>
									<td>D<input type="text" name="inputTextMultipleOptionD" id="inputTextMultipleOptionD" required="required"/></td>
									<td>

											A<input type="radio" name="radioCorrectAnswer"  id="radioCorrectAnswerA"  required="required" value="A" />
											B<input type="radio" name="radioCorrectAnswer"  id="radioCorrectAnswerB"  required="required" value="B" />
											C<input type="radio" name="radioCorrectAnswer"  id="radioCorrectAnswerC"  required="required" value="C" />
											D<input type="radio" name="radioCorrectAnswer"  id="radioCorrectAnswerD"  required="required" value="D" />

									</td>
									<td>
										<input type="text" name="textMultipleInputQuestionID" id="textMultipleInputQuestionID" style="display: none;"/><!--style="display: none;"-->
										<input type="text" name="textMultipleInputSubjectID" id="textMultipleInputSubjectID" style="display: none;"/>
									</td>
									<td><input type="submit" value="Enviar Pregunta"/></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
				<!--Section for multiple questions-->
				<!--editing this section-->
			</div>
			</div>


			<!--Developing this section for Multiple-->
			<!--Module to add questions to subject-->

			<div class="showAddedQuestions" id="showAddedQuestions"></div>

		</section>

		<footer>
			<p>Hecho en México, Universidad Nacional Autónoma de México (UNAM), todos los derechos reservados 2017.</p>
			<p>Esta página puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica.</p>
			<p>De otra forma, requiere permiso previo por escrito de la institución.</p>
			<div id="dFooter">
				<li>
					<ul class="ulFooter"><a href="#">Créditos</a></ul>
					<ul class="ulFooter"><a href="#">Conoce el portal</a></ul>
				</li>
			</div><br><br>
			<p>Última actualización: 22/11/2017</p>
		</footer>
	</body>
</html>
