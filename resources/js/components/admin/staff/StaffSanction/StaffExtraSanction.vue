<template>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

                    <span class="h2"> مكافئات الاضافي  </span>

                </div>
                <div class="card-body" id="printme">

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                                    <th class="wd-15p border-bottom-0">نوع الاضافي</th>

                                    <th class="wd-15p border-bottom-0">التاريخ</th>
                                    <th class="wd-15p border-bottom-0">البند</th>
                                    <th class="wd-15p border-bottom-0">الوقت</th>
                                    <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>

                                    <th class="wd-15p border-bottom-0">الجزاء</th>
                                    <!-- <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th> -->

                                    <th class="wd-15p border-bottom-0"> الحاله</th>


                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody v-if="value_list && value_list.data.length > 0">
                                <tr v-for="(extra, index) in value_list.data" :key="index">


                                    <td>{{ extra.name }}


                                    </td>

                                    <td>



                                        اضافي {{ extra.sanctionable.type_name }}

                                    </td>
                                    <td>



                                        {{ extra.sanction_date }}

                                    </td>



                                    <td>

                                        علي {{ extra.sanctionable.discount_name }}

                                    </td>
                                    <td>
                                        {{ extra.sanctionable.part_name }}

                                    </td>
                                    <td>
                                        {{ extra.sanctionable.iteration }}

                                    </td>
                                    <td>
                                        {{ extra.sanctionable.sanction }}
                                    </td>

                                    <td style="color:goldenrod">
                                        <span v-if="extra.status == 0" class="badge text-bg-warning">غير معتمد</span>
                                        <span v-if="extra.status == 1" class="badge text-bg-success"> معتمد</span>

                                    </td>
                                    <td>
                                        <div class="optionbox">
                                            <select v-model="status_selected[index]" @change="change_status(
                                                index,
                                                extra.id,
                                                extra.sanction_date,
                                                extra.sanctionable.sanction,
                                                extra.sanctionable_id,
                                                extra.sanctionable_type,
                                                extra.extra_id
                                            )" class="form-control">
                                                <option :selected="true" class="btn btn-success" v-bind:value="1">
                                                    معتمد
                                                </option>

                                                <option :selected="true" class="btn btn-success" v-bind:value="0">
                                                    غير معتمد
                                                </option>

                                            </select>
                                        </div>


                                    </td>

                                    <td>
<!-- 
                                        <button v-if="extra.status == 0" onclick="change_status(
                                                index,
                                                extra.id,
                                                extra.sanction_date,
                                                extra.sanctionable.sanction,
                                                extra.sanctionable_id,
                                                extra.sanctionable_type,
                                                extra.extra_id
                                            )" data-v-bab7fb96="" type="button" class="btn btn-primary">اعتماد الاضافي
                                        </button>

                                        <button v-else data-v-bab7fb96="" type="button" class="btn btn-primary" disabled>اعتماد
                                            الاضافي </button> -->


                                        <!-- <div class="optionbox">
                                            <select v-model="status_selected[index]" @change="change_status(
                                                index,
                                                extra.id,
                                                extra.sanction_date,
                                                extra.sanctionable.sanction,
                                                extra.sanctionable_id,
                                                extra.sanctionable_type,
                                                extra.extra_id
                                            )" class="form-control">
                                                <option :selected="true" class="btn btn-success" v-bind:value="1">
                                                    معتمد
                                                </option>

                                                <option :selected="true" class="btn btn-success" v-bind:value="0">
                                                    غير معتمد
                                                </option>

                                            </select>
                                        </div> -->


                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="6" style="color:red;font-size: x-large;">الاجمالي</td>
                                    <td colspan="2">


                                        <input v-model="grand_total" type="number" class="form-control" name="name"
                                            id="name" readonly />
                                    </td>

                                    <td>


                           
                                        
                                        <button data-v-bab7fb96="" type="button" class="btn btn-primary">اعتماد
                                            الكل </button>

                                    </td>


                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">لايوجد بياتات.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <pagination align="center" :data="extras" @pagination-change-page="list"></pagination> -->
                    <pagination align="center"  @pagination-change-page="list"></pagination>
                </div>
       
            </div>
        </div>
        <!--/div-->
    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';
export default {
    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {


 
            group_account: '',
            grand_total: '',
            status_selected: [],


        };
    },
    mounted() {
        this.list();
        this.counts[0] = 1;
        this.type = 'extra_sanction';
    },
    methods: {

        // calc_grand_total(count) {

        //     var quantity = 0;

        //     for (let index = 0; index < count; index++) {

        //         quantity = parseInt(quantity) + parseInt(this.quantity[index + 1]);

        //     }

        //     this.grand_total = quantity;


        // },
        list(page = 1) {
            this.axios
                .post(`/staff_extra_sanction?page=${page}`)
                .then(({ data }) => {

                    console.log(data);
                    this.value_list = data.list;
                    this.group_account = data.group_account;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        change_status(
            index,
            staff,
            date,
            sanction,
            sanctionable_id,
            sanctionable_type,
            extra_id
        ) {

            this.axios
                .post(`/change_status_extra_sanction`, {

                    sanctionable_id: sanctionable_id,
                    sanctionable_type: sanctionable_type,
                    staff: staff,
                    date: date,
                    sanction: sanction,
                    status: this.status_selected[index],

                    debit: {

                        account_id: this.group_account[0].account_second_id,
                        value: sanction,

                    },
                    credit: {

                        account_id: this.group_account[0].account_id,
                        account_details: extra_id,
                        value: sanction,
                    },
                    daily_index: 1,
                    grand_total: sanction,
                    type_daily: 'hr_extra',


                })
                .then(({ data }) => {

                    toastMessage("تم التعديل بنجاح");
                    // this.value_list = data.list;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        }

    },
};
</script>

<style scoped>
.optionbox select {
    background: #E62968;
    color: #fff;
    padding: 10px;
    width: 120px;
    height: 30px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 18px rgb(93, 15, 9);
    -webkit-appearance: button;
    outline: none;
}
</style>