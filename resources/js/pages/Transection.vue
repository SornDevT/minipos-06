<template>
    <div>
        <div class="card">
  <h5 class="card-header">ທານເຄື່ອນໄຫວ ທຸລະກຳ</h5>
  <div class=" d-flex justify-content-end ">
            <div class="btn-group me-2 " role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-secondary" @click="month_type='m'" > <i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                <button type="button" class="btn btn-outline-secondary" @click="month_type='y'" > <i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
              </div>
            <input type="date" class=" form-control me-2" v-model="dmy" style=" width:150px" >

            <button type="button" class="btn rounded-pill btn-outline-secondary me-4" @click="GetDataTransection()">ສະແດງການເຄື່ອນໄຫວ</button>
  </div>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center" width="120">ວັນທີ່</th>
            <th class="text-center"  width="100">ເລກທີ່ທຸລະກຳ</th>
            <th class="text-center"  width="100">ປະເພດທຸລະກຳ</th>
            <th class="text-center">ລາຍລະອຽດ</th>
            <th class="text-center"  width="180" >ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in Transection.data" :key="list.id">
            <td>{{ date(list.created_at) }}</td>
            <td>{{  list.tran_id  }}</td>
            <td>{{ list.tran_type  }}</td>
            <td>{{ list.tran_detail }}</td>
            <td class="text-end">{{ formatPrice(list.price) }}</td>
          </tr>
        </tbody>
      </table>
      <panition :pagination="Transection" :offset="4" @paginate="GetDataTransection($event)" />
    </div>
  </div>
</div>
    </div>
</template>

<script>

import moment from "moment";

export default {
    name: 'Minipos6Transection',

    data() {
        return {
            Transection:[],
            month_type:'m',
            dmy:'',
        };
    },
    components:{
        moment
    },

    mounted() {
        
    },

    methods: {
        formatPrice(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+" ກີບ";
		},
        date(value){
            return moment(value).format("DD/MM/YYYY");
        },
        GetDataTransection(page){

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.post(`api/transection?page=${page}`,{
                month_type: this.month_type,
                dmy: this.dmy
            }).then((response)=>{

                this.Transection = response.data;
            }).catch((error)=>{
                console.log(error);
            });
            });


            }
    },
    created(){
        this.GetDataTransection();
    }
};
</script>

<style lang="scss" scoped>

</style>