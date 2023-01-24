<template>
    <div>
        <div class="row">
            <div class=" col-md-8">
                <div class=" card mb-4">
                        <div class=" card-body ">
                            <input type="text" class=" form-control " v-model="Search" @keyup.enter="GetDataStore()" placeholder="ຄົ້ນຫາຂໍ້ມູນ...." name="" id="">
                        </div>
                </div>

                <div class="row" style=" overflow:auto; height:65vh;">

                    <div class="col-md-3 mb-4" v-for="list in StoreData.data" :key="list.id">
                        <div class="card h-100 cursor" @click="add_product(list.id)">
                            <span v-for="it in ListOrder" :key="it.index">
                                    <span class="box-num" v-if="list.id == it.id"> {{ it.order_amount }} </span>
                            </span>
                        <img class="card-img-top img-cover-pos"  :src="'assets/img/'+list.image" alt="Card image cap" v-if="list.image">
                        <img class="card-img-top img-cover-pos" :src="'assets/img/no-image.png'" alt="Card image cap" v-if="!list.image">
                        <div class="card-body p-1">
                           
                            <p class="card-text text-center">
                            {{list.name}}<br>
                            {{formatPrice(list.price_sell)}}
                            </p>
                        
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class=" col-md-4" >

                <div class=" card ">
                    <div class=" card-body ">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">ຊື່ລູກຄ້າ</label>
                                <input type="text" class=" form-control " v-model="customer_name">
                                <label for="">ເບີໂທ</label>
                                <input type="text" class=" form-control " v-model="customer_tel">
                            </div>
                        </div>
                        <hr>
                            <div class=" d-flex justify-content-between mb-2 ">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(TotalAmount) }}</span>
                            </div>
                            <button type="button" class="btn rounded-pill btn-success mb-2" style="width:100%" :disabled="checklist" @click="Confirm_pay()" >ຊຳລະເງິນ</button>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <td>ລາຍການ</td>
                                    <td>ລາຄາ</td>
                                    <td>ລວມ</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in ListOrder" :key="item.id">
                                   <td>{{item.name}}</td>
                                   <td>{{ formatPrice(item.price_sell)}}<br> <i class='bx bxs-plus-circle text-info cursor' @click="add_product(item.id)"></i> {{ item.order_amount }} <i class='bx bxs-minus-circle text-info cursor' @click="remove_one_product(item.id)"></i> | <i class='bx bxs-x-circle text-danger cursor' @click="remove_product(item.id)"></i> </td>
                                   <td>{{ formatPrice(item.price_sell*item.order_amount) }}</td>
                                </tr>
                              
                               
                                </tbody>
                            </table>
                    </div>
                </div>

            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="backDropModalTitle">ຊຳລະສິນຄ້າ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class=" d-flex justify-content-between ">
                    <span>
                        <p> <strong> ຍອດເງິນ: </strong></p>
                        <p> <strong>ຮັບເງິນນຳລູກຄ່າ:</strong></p>
                    </span>
                    <span>
                        <p class="text-end"><strong>{{ formatPrice(TotalAmount) }}</strong></p>
                        <p class="text-end"><strong>{{ formatPrice(CashAmount) }}</strong></p>
                    </span>
                  </div>
                  <div class=" d-flex justify-content-between text-danger " v-if="CashAmount-TotalAmount>0">
                    <p> <strong> ເງິນທອນ: </strong></p>
                    <p class="text-end"> <strong> {{ formatPrice(CashAmount-TotalAmount)}}</strong></p>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <cleave :options="options"  name="" class=" form-control" id="" style="text-align:right" v-model="CashAmount" />
                    </div>
                    <div class="col-md-12">
                        <div class="p-2 justify-content-center d-flex mb-4">
                            <div class="row" style="width: 250px;">
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(1)" style="width: 60px;">1</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(2)" style="width: 60px;">2</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(3)" style="width: 60px;">3</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(4)" style="width: 60px;">4</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(5)" style="width: 60px;">5</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <button type="button" class="btn btn-primary btn-lg text-white" @click="AddNum(6)" style="width: 60px;">6</button>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(7)" style="width: 60px;">7</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(8)" style="width: 60px;">8</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(9)" style="width: 60px;">9</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum('00')" style="width: 60px;">00</a>
                                </div><div class="col-4 text-center mt-2">
                                    <a class="btn btn-primary btn-lg text-white" @click="AddNum(0)" style="width: 60px;">0</a>
                                </div>
                                <div class="col-4 text-center mt-2">
                                    <a class="btn btn-danger btn-lg text-white" @click="AddNum('-')" style="width: 60px;"><i class='bx bx-arrow-back'></i></a>
                                </div>
                            </div>
                        </div>
                        <div class=" justify-content-center d-flex">
                            <button type="button" class="btn rounded-pill btn-info" :disabled="CheckAmout" @click="Pay()" >ຊຳລະເງິນ</button>
                        </div>
                    </div>
                  </div>
            
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
      
                </div>
            </div>
            </div>
          </div>

    </div>
</template>

<script>
export default {
    name: 'Minipos6Pos',

    data() {
        return {
            customer_name:'',
            customer_tel:'',
            Search:'',
            StoreData:[],
            ListOrder:[],
            CashAmount:'',
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
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            return this.ListOrder.reduce((num,item) => num + item.price_sell*item.order_amount,0);
        },
        checklist(){
            if(this.TotalAmount>0){
                return false;
            } else {
                return true;
            }
        },
        CheckAmout(){
                if(this.CashAmount>=this.TotalAmount){
                    return false;
                } else {
                    return true;
                }
        }
    },
    methods: {
        Pay(){

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post("/api/transection/add", {
                    acc_type:'income',
                    listorder: this.ListOrder,
                    customer_name: this.customer_name,
                    customer_tel: this.customer_tel
                }).then((response)=>{


                  if(response.data.success){

                    window.open(window.location.origin+'/api/bill/'+response.data.bill_id, "_blank");

                    $('#backDropModal').modal('hide');
                    this.ListOrder = [];
                    this.CashAmount = '';
                    this.GetDataStore();

                    this.$swal(
                        'ການຊຳລະເງິນ',
                        response.data.message,
                        'success'
                      );

                  } else {

                    this.$swal(
                        'ການຊຳລະເງິນ',
                        response.data.message,
                        'error'
                      );

                  }

                  this.GetDataStore();
                  
                }).catch((error)=>{
                  console.log(error)
                });
              });
        },
        Confirm_pay(){
                
            $('#backDropModal').modal('show');
        },
        AddNum(num){
            if(num == '-'){
                this.CashAmount = this.CashAmount.slice(0,-1);
            } else {
                //console.log(this.CashAmount + num);
                this.CashAmount =  this.CashAmount + num;
            }
        },
        add_product(id){
                let item = this.StoreData.data.find((i)=>i.id == id);

               console.log(item);

                    if(item.amount>0){

                        let list_order = this.ListOrder.find((i)=>i.id == id);

                        if(list_order){ // ຖ້າມີໃນລາຍການສັ່ງຊື້

                            let old_order = list_order.order_amount;

                                // console.log(old_order.amount)

                                if(item.amount-old_order>0){
                                    list_order.order_amount++;
                                } else {
                                    this.$swal(
                                            'ສິນຄ້ານີ້',
                                            'ໝົດແລ້ວ!',
                                            'error'
                                        );
                                }

                                    
                        } else { // ຖ້າບໍ່ມີໃນລາຍການ ເພີ່ມໃໝ່
                            this.ListOrder.push({
                                id: item.id,
                                name: item.name,
                                price_sell: item.price_sell,
                                order_amount: 1
                            });
                        }


                } else{
                    this.$swal(
                        'ສິນຄ້ານີ້',
                        'ໝົດແລ້ວ!',
                        'error'
                      );
                }

                

                
        },
        remove_one_product(id){

            let list_order = this.ListOrder.find((i)=>i.id == id);

            if(list_order){
                list_order.order_amount--;

                if(list_order.order_amount<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=> i.id).indexOf(id),1);
                }
            }
             
        },
        remove_product(id){
            this.ListOrder.splice(this.ListOrder.map((i)=> i.id).indexOf(id),1);
        },
        formatPrice(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" ກີບ";
		},
        GetDataStore(page){

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.get(`api/store?page=${page}&search=${this.Search}`).then((response)=>{
                this.StoreData = response.data;
            }).catch((error)=>{
                console.log(error);
                if(error.response.status==401){ this.$storage.setStorageSync("isLoggin", false); location.reload(); }
            });
            });

            }
    },
    created(){
        this.GetDataStore();
    },
    watch:{
        "Search"(){
          if(this.Search == ''){
            this.GetDataStore();
          }
        },
    }
};
</script>

<style>
.cursor{
    cursor: pointer;
}
.box-num{
    position: absolute;
    right: 0px;
    top: 0;
    background-color: #00c7ff;
    color: white;
    padding: 8px;
    border-radius: 0px 0px 0px 10px;
    font-weight: bold;
}
    .img-cover-pos{
        width: 100%;
    height: 110px;
    object-fit: cover;
    object-position: center;
    }
</style>