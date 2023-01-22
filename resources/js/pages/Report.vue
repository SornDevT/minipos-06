<template>
    <div>
        <div class="row">
            <div class="col-md-8"><div class="card">
  <h5 class="card-header">ລາຍງານ </h5>

  <div class=" d-flex justify-content-end ">
            <div class="btn-group me-2 " role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-secondary" @click="month_type='m'" > <i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                <button type="button" class="btn btn-outline-secondary" @click="month_type='y'" > <i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
              </div>
            <input type="date" class=" form-control me-2" v-model="dmy" style=" width:150px" >

            <button type="button" class="btn rounded-pill btn-outline-secondary me-4" @click="CreateReport()">ສ້າງລາຍງານ</button>
  </div>

  <div class="p-4">
        <MonthlyChart/>
  </div>
  
</div></div>
            <div class="col-md-4">
            <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຮັບ</span>
                                <span>12.000 k</span>
                            </div>
                </div>
            </div>
            <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຈ່າຍ</span>
                                <span>12.000 k</span>
                            </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ກຳໄລ</span>
                                <span>12.000 k</span>
                            </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import MonthlyChart from '../components/MonthlyChart.vue'

export default defineComponent({
    name: 'Minipos6Report',

    data() {
        return {
            month_type:'m',
            dmy:'',
            data_income:[],
            data_expense:[],

        };
    },
    components:{
        MonthlyChart
    },

    mounted() {
        
    },

    methods: {

        CreateReport(){

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
            this.$axios.post(`api/report`,{
                month_type: this.month_type,
                dmy: this.dmy
            }).then((response)=>{

                this.data_income = response.data.income;
                this.data_expense = response.data.expense;
                
            }).catch((error)=>{
                console.log(error);
            });
            });
        }
        
    },
});
</script>

<style lang="scss" scoped>

</style>