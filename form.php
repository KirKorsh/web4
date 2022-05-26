<style>
#content, header div{
    max-width: 960px;
    margin: 0 auto;
}
body{
    font-family: "Montserrat", sans-serif;
}
div.table ,#form, div.link-list{
    
}
label {
    margin:10px 0;
}
input[type=text] {
  padding:10px;
  margin:10px 0;
  border:1;
    border-radius:15px;
  box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
}
input[type=email] {
  padding:10px;
  margin:10px 0;
  border:1;
    border-radius:15px;
  box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
}
select {
  padding:10px;
  border-radius:10px;
}
textarea {
  resize: vertical;
  padding:15px;
  margin:10px 0;
  border-radius:15px;
  border:1;
  box-shadow:4px 4px 10px rgba(0,0,0,0.06);
  height:150px;
}
.error {
    border: 3px solid red;
  }
</style>
<?php
if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}
?>
<body>
   <div id="form">
    <h1>Форма контракта</h1>

    <form action="index.php" method="POST">

      <label>
        Имя:<br />
        <input type="text" name="name" placeholder="Name" <?php if ($errors['name']) {print 'class="error"';} ?>
          value="<?php print $values['name']; ?>" />
      </label><br />

      <label>
        Еmail:<br />
        <input name="email" type="email" placeholder="Email"
          value="<?php print $values['email']; ?>"
	<?php if ($errors['email']) {print 'class="error"';} ?>
	/>
      </label><br />

      <label>
        Год рождения:<br />
        <select name="year" <?php if ($errors['year']) {print 'class="error"';} ?>> 
	  <option value="Год">Год рождения</option>
           <?php
             for($i=1890;$i<=2022;$i++){
             if($values['year']==$i){
             printf("<option value=%d selected>%d </option>",$i,$i);
              }
             else{
             printf("<option value=%d>%d </option>",$i,$i);
            }
          }
          ?>
         </select>
      </label><br />
	  
	  Пол:<br />
     <div <?php if ($errors['radio-1']) {print 'class="error"';} ?>>
      <label> <input type="radio" name="radio-1" value="man" 
	<?php if($values['radio-1']=="man") {print 'checked';} ?> />
        Мужской </label>
      <label><input type="radio" name="radio-1" value="female" 
	<?php if($values['radio-1']=="female") {print 'checked';} ?> />
        Женский</label><br />
     </div>
		
	  Количество конечностей:<br />
     <div <?php if ($errors['radio-2']) {print 'class="error"';} ?>>
      <label><input type="radio" name="radio-2" value="1" 
	<?php if($values['radio-2']=="1") {print 'checked';} ?> />
        1</label>
      <label><input type="radio"name="radio-2" value="2" 
	<?php if($values['radio-2']=="2") {print 'checked';} ?> />
        2</label>
      <label><input type="radio" name="radio-2" value="3" 
	<?php if($values['radio-2']=="3") {print 'checked';} ?> />
        3</label>
      <label><input type="radio" name="radio-2" value="4" 
	<?php if($values['radio-2']=="4") {print 'checked';} ?> />
        4</label><br />
      </div>
		
	  <label>
        Сверхспособности:
        <br />
        <select name="super[]" multiple="multiple"
	  <?php if ($errors['super']) {print 'class="error"';} ?> >
          <option value="fly" <?php if($values['fly']==1){print 'selected';} ?> > Летать</option>
          <option value="sleep" <?php if ($values['sleep']==1){print 'selected';} ?> > Спать</option>
          <option value="run" <?php if ($values['run']==1){print 'selected';} ?> > Бегать</option>
        </select>
      </label><br />
	  
      <label>
        Дополнительное описание:<br />
        <textarea name="bio" placeholder="Write something pls"> <?php print $values['bio']; ?> </textarea>
      </label><br />
	  
      <div <?php if ($errors['check-1']) {print 'class="error"';} ?> >
      <label><input type="checkbox" name="check-1"
	<?php if($values['check-1']==TRUE){print 'checked';} ?> />
        Разрешение на использование личной информации дал(а)</label><br />
      </div>
      <input type="submit" value="Send" />
    </form>
   </div>
</body>