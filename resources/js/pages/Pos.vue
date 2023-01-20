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
                            <div class=" d-flex justify-content-between mb-2 ">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(TotalAmount) }}</span>
                            </div>
                            <button type="button" class="btn rounded-pill btn-success mb-2" style="width:100%">ຊຳລະເງິນ</button>

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
    </div>
</template>

<script>
export default {
    name: 'Minipos6Pos',

    data() {
        return {
            Search:'',
            StoreData:[],
            ListOrder:[],
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            return this.ListOrder.reduce((num,item) => num + item.price_sell*item.order_amount,0);
        }
    },
    methods: {
        add_product(id){
                let item = this.StoreData.data.find((i)=>i.id == id);

                let list_order = this.ListOrder.find((i)=>i.id == id);

                if(list_order){

                            list_order.order_amount++;
                } else {
                    this.ListOrder.push({
                        id: item.id,
                        name: item.name,
                        price_sell: item.price_sell,
                        order_amount: 1
                    });
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