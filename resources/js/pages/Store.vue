<template>
    <div>
        <div class="card">
            {{ FormShow }}
            <hr>
            {{ FormStore }}
            <hr>
            StoreData: {{ StoreData }}
            <hr>
         <div class=" d-flex justify-content-between ">
                    <h5 class="card-header">Bordered Table</h5>
                    <div class=" p-4 ">
                        <button type="button" class="btn rounded-pill btn-info" v-if="!FormShow" @click="FormShow=true" >ເພີ່ມຂໍ້ມູນ</button>
                        <button type="button" class="btn rounded-pill btn-success me-2 " v-if="FormShow" @click="add_store()" >ບັນທຶກ</button>
                        <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="FormShow=false" >ຍົກເລີກ</button>

                    </div>
                    

        </div>

  
  <div class="card-body">
    
    <div class="row" v-if="FormShow">
        <div class="col-md-3">
                aaaaaaaa
        </div>
        <div class="col-md-9">
            <div class="mb-3">
            <label  class="form-label">ຊື່ສິນຄ້າ</label>
            <input type="text" class="form-control"  placeholder="ປ້ອນຊື່ສິນຄ້າ..." v-model="FormStore.name" >
            </div>
            <div class="mb-3">
            <label  class="form-label">ຈຳນວນ</label>
            <input type="number" class="form-control"  placeholder="ປ້ອນຈຳນວນ..." v-model="FormStore.amount" >
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label  class="form-label">ລາຄາຊື້</label>
                    <input type="text" class="form-control" placeholder="ປ້ອນລາຄາຊື້..." v-model="FormStore.price_buy" >
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                <label  class="form-label">ລາຄາຂາຍ</label>
                <input type="text" class="form-control"  placeholder="ປ້ອນລາຄາຂາຍ..." v-model="FormStore.price_sell" >
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!FormShow">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ຮູບ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          
       
          <tr v-for="list in StoreData" :key="list.id" >
            <td> {{ list.id }} </td>
            <td>{{ list.name }}</td>
            <td>
              {{ list.image }}
            </td>
            <td>{{ list.price_buy }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="edit_store(list.id)" ><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="Del_store(list.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
    </div>
</template>

<script>
export default {
    name: 'Minipos6Store',

    data() {
        return {
            IDupdate:'',
            FormShow:false,
            FormType:false,
            StoreData:[{ "id": 320, "name": "ເກີບຜ້າໃບ", "amount": 50, "price_buy": "10000", "price_sell": "20000" }, { "id": 142, "name": "ກະເປົາຜູ້ຍິງ", "amount": 50, "price_buy": "20000", "price_sell": "30000" }, { "id": 718, "name": "ສະປູອາບນ້ຳ", "amount": 100, "price_buy": "5000", "price_sell": "12000" }],
            FormStore:{
                name:'',
                amount:'',
                price_buy:'',
                price_sell:'',
                iamge:''
            }
        };
    },

    mounted() {
        
    },

    methods: {
        add_store(){

            // ກວດຊອບເງື່ອນໄຂ
            if(this.FormType){

                // ອັບເດດຂໍ້ມູນ
                this.StoreData.find((i)=>i.id==this.IDupdate).name = this.FormStore.name;
                this.StoreData.find((i)=>i.id==this.IDupdate).amount = this.FormStore.amount;
                this.StoreData.find((i)=>i.id==this.IDupdate).price_buy = this.FormStore.price_buy;
                this.StoreData.find((i)=>i.id==this.IDupdate).price_sell = this.FormStore.price_buy;


            } else {

                // ເພີ່ມຂໍ້ມູນ
                this.StoreData.push({
                    id: Math.floor(Math.random()*1000),
                    name: this.FormStore.name,
                    amount: this.FormStore.amount,
                    price_buy: this.FormStore.price_buy,
                    price_sell: this.FormStore.price_sell,
                    image:''
                });

            }


            // ເຄຼຍຂໍ້ມູນໃນຟອມ
            this.FormStore.name = '';
            this.FormStore.amount = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';

            // ປິດຟອມ ແລະ ສະແດງຕາຕະລາງ
            this.FormShow = false;

            // ກຳນົດເງືອນໄຂໃຫ້ທຳການເພີ່ມຂໍ້ມູນໃໝ່
            this.FormType = false;


        },
        edit_store(id){

            // ກຳນົດເງືອນໄຂໃຫ້ທຳການອັບເດດຂໍ້ມູນ
            this.FormType = true;

            //console.log(id);
            this.IDupdate = id;
            // ຄົ້ນຫາຂໍ້ມູນ
            let item = this.StoreData.find((i)=>i.id==id);
           // console.log(item);

           // ນຳຂໍ້ມູນທີ່ຄົ້ນຫາໄດ້ ມາໃສ່ໃນຟອມ
            this.FormStore.name = item.name;
            this.FormStore.amount = item.amount;
            this.FormStore.price_buy = item.price_buy;
            this.FormStore.price_sell = item.price_sell;

            // ເປິດຟອມ ແລະ ສະແດງຕາຕະລາງ
            this.FormShow = true;
        },
        Del_store(id){

            let index = this.StoreData.map((i)=>i.id).indexOf(id);
            this.StoreData.splice(index,1);
            console.log(index);
        }
    },
};
</script>

<style >

</style>