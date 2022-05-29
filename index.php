<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Arbuz</title>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id='vueapp'>
    <form @submit.prevent = "handleSubmit">
      <label>Row</label>
      <input list="row" name="row" v-model="row" required>
      <datalist id="row">
        <option value="1">
        <option value="2">
        <option value="3">
      </datalist>
      </br>
      <label>Column</label>
      <input list="column" name="column" v-model="column" required>
      <datalist id="column">
        <option value="1">
        <option value="2">
        <option value="3">
      </datalist>
      </br>
      <label>Status</label>
      <input list="status" name="status" v-model="status" required>
      <datalist id="status">
        <option value="Ripe">
        <option value="Unripe">
        <option value="Already picked">
      </datalist>
      </br>
      <label>Quantity</label>
      <input list="quantity" name="quantity" v-model="quantity" required>
      </br>
      <datalist id="quantity">
        <option value="1">
        <option value="2">
        <option value="3">
      </datalist>
      <label>Weight</label>
      <input list="weight" name="weight" v-model="weight" required>
      </br>
      <datalist id="weight">
        <option value="0-3">
        <option value="3-6">
        <option value="6-9">
        <option value="9-12">
        <option value="12-15">
      </datalist>
      <label>Address</label>
      <input type="text" name="address" v-model="address" required>
      </br>
      <label>Phone</label>
      <input type="text" name="phone" v-model="phone" required>
      </br>
      <label>Date</label>
      <?php 
        $min = date('Y-m-d');
        $max = date('Y-m-d', strtotime('+9 days'));
      ?>
      <input type="date" name="date" v-model="date" min = "<?= $min ?>" 
              max="<?= $max ?>" required>
      </br>
      <label>Time</label>
      <input type="time" name="time" v-model="time" required>
      </br>
      <input type="checkbox" name="cut" v-model="cut">
      <label>Cut watermelons</label>
      </br>
      <div class = "submit">
        <button @click="createOrder()">Order</button>
      </div>
    </form>
  </div>
  <script>
  var app = new Vue({
    el: '#vueapp',
    data: {
        row: '',
        column: '',
        status: '',
        quantity: '',
        weight: '',
        address: '',
        phone: '',
        date: '',
        time: '',
        cut: '',
        orders: []
    },
    methods: {
      createOrder: function(){
        let formData = new FormData();
        formData.append('row', this.row);
        formData.append('column', this.column);
        formData.append('status', this.status);
        formData.append('quantity', this.quantity);
        formData.append('weight', this.weight);
        formData.append('address', this.address);
        formData.append('phone', this.phone);
        formData.append('date', this.date);
        formData.append('time', this.time);
        formData.append('cut', this.isCut);

        var order = {};
        formData.forEach(function(value, key){
          order[key] = value;
        });

        axios({
          method: 'post',
          url: 'orders.php',
          data: formData,
          config: { headers: {'Content-Type': 'multipart/form-data' }}
        })
        .then(function (response) {
            console.log(response)
            app.orders.push(order)
            app.resetForm();
        })
        .catch(function (response) {
            console.log(response)
        });
      },
      resetForm: function(){
        this.row = '';
        this.column = '';
        this.status = '';
        this.quantity = '';
        this.weight = '';
        this.address = '';
        this.phone = '';
        this.date = '';
        this.time = '';
        this.cut = '';
      },
      handleSubmit() {
        console.log("form submitted");
      }
    }
  })    
  </script>
</body>
</html>