<template>
    <div>
        <div class="card"> 
            <!-- {{ FormShow }}
            <hr>
            {{ FormStore }}
            <hr>
            StoreData: {{ StoreData }}
            <hr> -->
         <div class=" d-flex justify-content-between ">
                    <h5 class="card-header">Bordered Table</h5>
                    <div class=" p-4 ">
                      <!-- <button @click="showAlert">Hello world</button> -->
                        <button type="button" class="btn rounded-pill btn-info" v-if="!FormShow" @click="FormShow=true" >ເພີ່ມຂໍ້ມູນ</button>
                        <button type="button" class="btn rounded-pill btn-success me-2 " v-if="FormShow" @click="add_store()" >ບັນທຶກ</button>
                        <button type="button" class="btn rounded-pill btn-danger" v-if="FormShow" @click="FormShow=false" >ຍົກເລີກ</button>

                    </div>
                    

        </div>

  
  <div class="card-body">
    
    <div class="row" v-if="FormShow">
        <div class="col-md-3" style=" position:relative">
          <div class="bt-del" v-if="image_product" >
            <button type="button" class="btn rounded-pill btn-icon btn-danger" @click="Delete_ing()">
                <i class='bx bxs-trash-alt'></i>
              </button>
          </div>
              

              <img :src="imagePreview" class="img-thumbnail mb-2" alt="" srcset="">
               <input type="file" class="form-control" @change="onSelected">
        </div>
        <div class="col-md-9">
            <div class="mb-3">
            <label  class="form-label">ຊື່ສິນຄ້າ</label>
            <input type="text" class="form-control"  placeholder="ປ້ອນຊື່ສິນຄ້າ..." v-model="FormStore.name" >
            </div>
            <div class="mb-3">
            <label  class="form-label">ຈຳນວນ</label>
            <cleave :options="options" class="form-control"  placeholder="ປ້ອນຈຳນວນ..." v-model="FormStore.amount" />
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                    <label  class="form-label">ລາຄາຊື້</label>
                    <cleave :options="options"  class="form-control" placeholder="ປ້ອນລາຄາຊື້..." v-model="FormStore.price_buy" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                <label  class="form-label">ລາຄາຂາຍ</label>
                <cleave :options="options" class="form-control"  placeholder="ປ້ອນລາຄາຂາຍ..." v-model="FormStore.price_sell" />
                </div>
                </div>
            </div>
        </div>
    </div>
      <div v-if="!FormShow">

        <div class="row mb-2 d-flex justify-content-end ">
            <div class="col-md-3"> 
              <input type="text" class="form-control" placeholder="ຄົ້ນຫາຂໍ້ມູນ..." v-model="Search" @keyup.enter="GetDataStore()" >
            </div>
      </div>
    <div class="table-responsive text-nowrap" >
      
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
          
       
          <tr v-for="list in StoreData.data" :key="list.id" >
            <td> {{ list.id }} </td>
            <td>{{ list.name }}</td>
            <td>
              <img :src="'assets/img/'+list.image" class="img-cover" v-if="list.image" >
              <img src="assets/img/no-image.png" class="img-cover" v-else >
            </td>
            <td>{{ formatPrice(list.price_buy) }}</td>
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

      <panition :pagination="StoreData" :offset="4" @paginate="GetDataStore($event)" />

    </div>
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
          imagePreview: window.location.origin+'/assets/img/upload-img.png',
          image_product:'',
          Search:'',
            options:{
             // prefix: '₭ ',
              numeral: true,
              numeralPositiveOnly: true,
              noImmediatePrefix: true,
              rawValueTrimPrefix: true,
              numeralIntegerScale: 10,
              numeralDecimalScale: 2,
              numeralDecimalMark: ',',
              delimiter: '.'
            },
            IDupdate:'',
            FormShow:false,
            FormType:false,
            StoreData:[],
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
      Delete_ing(){
        this.imagePreview = window.location.origin+'/assets/img/upload-img.png';
        this.image_product = '';
      },
      onSelected(event){
        // console.log(event);
        this.image_product = event.target.files[0];

        let reader = new FileReader();
        reader.readAsDataURL(this.image_product);
        reader.addEventListener("load", function(){
          this.imagePreview = reader.result;
        }.bind(this), false);

      },
      formatPrice(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" ກີບ";
		},
    //   showAlert() {
    //   // Use sweetalert2
   // this.$swal('Hello Vue world!!!');
    //.fire('Any fool can use a computer')
    // },
        add_store(){

            // ກວດຊອບເງື່ອນໄຂ
            if(this.FormType){

                // ອັບເດດຂໍ້ມູນ
                // this.StoreData.find((i)=>i.id==this.IDupdate).name = this.FormStore.name;
                // this.StoreData.find((i)=>i.id==this.IDupdate).amount = this.FormStore.amount;
                // this.StoreData.find((i)=>i.id==this.IDupdate).price_buy = this.FormStore.price_buy;
                // this.StoreData.find((i)=>i.id==this.IDupdate).price_sell = this.FormStore.price_buy;

                let formDataStore = new FormData();
                formDataStore.append("name", this.FormStore.name);
                formDataStore.append("amount", this.FormStore.amount);
                formDataStore.append("price_buy", this.FormStore.price_buy);
                formDataStore.append("price_sell", this.FormStore.price_sell);
                formDataStore.append("file", this.image_product);
                
                this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post(`/api/store/update/${this.IDupdate}`, formDataStore,{headers:{"content-typr":"multipart/form-data"}}).then((response)=>{

                ///console.log(response.data);

                  this.GetDataStore();
                  if(response.data.success){
                    this.$swal(
                        'ການອັບເດດຂໍ້ມູນ',
                        response.data.message,
                        'success'
                      );

                    } else {

                    this.$swal(
                        'ການອັບເດດຂໍ້ມູນ',
                        response.data.message,
                        'error'
                      );

                    }
                  
                }).catch((error)=>{
                  console.log(error)
                });
              });



            } else {

                // ເພີ່ມຂໍ້ມູນ
                // this.StoreData.push({
                //     id: Math.floor(Math.random()*1000),
                //     name: this.FormStore.name,
                //     amount: this.FormStore.amount,
                //     price_buy: this.FormStore.price_buy,
                //     price_sell: this.FormStore.price_sell,
                //     image:''
                // });

                let formDataStore = new FormData();
                formDataStore.append("name", this.FormStore.name);
                formDataStore.append("amount", this.FormStore.amount);
                formDataStore.append("price_buy", this.FormStore.price_buy);
                formDataStore.append("price_sell", this.FormStore.price_sell);
                formDataStore.append("file", this.image_product);
                formDataStore.append("acc_type", "expense");

                this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post("/api/store/add", formDataStore,{headers:{"content-typr":"multipart/form-data"}}).then((response)=>{

                 // console.log(response.data);

                  if(response.data.success){

                    this.$swal(
                        'ການບັນທຶກຂໍ້ມູນ',
                        response.data.message,
                        'success'
                      );

                  } else {

                    this.$swal(
                        'ການບັນທຶກຂໍ້ມູນ',
                        response.data.message,
                        'error'
                      );

                  }

                  this.GetDataStore();
                  
                }).catch((error)=>{
                  console.log(error)
                });
              });



            }


            // ເຄຼຍຂໍ້ມູນໃນຟອມ
            this.FormStore.name = '';
            this.FormStore.amount = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';
            this.imagePreview = window.location.origin+'/assets/img/upload-img.png';
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
            // let item = this.StoreData.find((i)=>i.id==id);
           // console.log(item);

           // ນຳຂໍ້ມູນທີ່ຄົ້ນຫາໄດ້ ມາໃສ່ໃນຟອມ
            // this.FormStore.name = item.name;
            // this.FormStore.amount = item.amount;
            // this.FormStore.price_buy = item.price_buy;
            // this.FormStore.price_sell = item.price_sell;
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.get(`api/store/edit/${this.IDupdate}`).then((response)=>{

             // console.log(response.data.name);

              this.FormStore.name = response.data.name;
              this.FormStore.amount = response.data.amount;
              this.FormStore.price_buy = response.data.price_buy;
              this.FormStore.price_sell = response.data.price_sell;
              
              this.image_product = response.data.image;

              if(response.data.image){
                this.imagePreview = window.location.origin+'/assets/img/'+ response.data.image;
              } else {
                this.imagePreview = window.location.origin+'/assets/img/no-image.png';
              }
              

            }).catch((error)=>{
              console.log(error);
            });
          });


            // ເປິດຟອມ ແລະ ສະແດງຕາຕະລາງ
            this.FormShow = true;
        },
        Del_store(id){

            // let index = this.StoreData.map((i)=>i.id).indexOf(id);
            // this.StoreData.splice(index,1);
            // console.log(index);

            this.$swal({
            title: 'ທ່ານແນ່ໃຈບໍ່?',
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ຕົກລົງ',
            cancelButtonText:'ຍົກເລີກ'
          }).then((result) => {
            if (result.isConfirmed) {

              
            // ຍຶນຍັນລຶບຂໍ້ມູນ
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.delete(`api/store/delete/${id}`).then((response)=>{

              //console.log(response.data);

              if(response.data.success){
                this.$swal(
                'ການລຶບຂໍ້ມູນ!',
                response.data.message,
                'success'
              );
              } else {
                this.$swal(
                'ການລອບຂໍ້ມູນ!',
                response.data.message,
                'error'
              );
              }

              this.GetDataStore();
              }).catch((error)=>{
              console.log(error);
              });
            });


              
            }
          })

          


        },
        GetDataStore(page){

          this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.get(`api/store?page=${page}&search=${this.Search}`).then((response)=>{
              //  console.log(response.data);
                this.StoreData = response.data;
            }).catch((error)=>{
              console.log(error);
              console.log(error.response.status);
              if(error.response.status==401){ this.$storage.setStorageSync("isLoggin", false); location.reload(); }
            });
          });


          // this.$axios.get("api/store").then((response)=>{
          //     //  console.log(response.data);
          //       this.StoreData = response.data;
          //   }).catch((error)=>{
          //     console.log(error);
          //   });
            

        }

    },
    watch:{
        "Search"(){
          if(this.Search == ''){
            this.GetDataStore();
          }
        },
        "FormShow"(){
              if(this.FormShow){
                // ເຄຼຍຂໍ້ມູນໃນຟອມ
            this.FormStore.name = '';
            this.FormStore.amount = '';
            this.FormStore.price_buy = '';
            this.FormStore.price_sell = '';
            this.imagePreview = window.location.origin+'/assets/img/upload-img.png';
              }
        }
    },
    created(){
      this.GetDataStore();
    }

};
</script>

<style >
.bt-del{
  position: absolute;
    top: 10px;
    right: 20px;
    z-index: 100;
}
 
</style>