<template>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

                    <span class="h2"> جزاءات التاخير  </span>

                </div>
                <div class="card-body" id="printme">

                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                                    <th class="wd-15p border-bottom-0">نوع الجراء</th>

                                    <th class="wd-15p border-bottom-0">التاريخ</th>
                                    <th class="wd-15p border-bottom-0">البند</th>
                                    <th class="wd-15p border-bottom-0">الوقت</th>
                                    <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>

                                    <th class="wd-15p border-bottom-0">الخصم</th>
                                    <!-- <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th> -->

                                    <th class="wd-15p border-bottom-0"> الحاله</th>


                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody v-if="value_list && value_list.data.length > 0">
                                <tr v-for="(delay, index) in value_list.data" :key="index">


                                    <td>{{ delay.name }}</td>



                                    <td>

                                        تأخير {{ delay.sanctionable.type_name }}

                                    </td>
                                    <td>



                                        {{ delay.sanction_date }}

                                    </td>
                                    <td>

                                        من {{ delay.sanctionable.discount_name }}

                                    </td>
                                    <td>
                                        {{ delay.sanctionable.part_name }}

                                    </td>
                                    <td>
                                        {{ delay.sanctionable.iteration }}

                                    </td>
                                    <td>
                                        {{ delay.sanctionable.sanction }}
                                    </td>
                                    <td style="color:goldenrod">
                                        <span v-if="delay.status == 0" class="badge text-bg-warning">غير معتمد</span>
                                        <span v-if="delay.status == 1" class="badge text-bg-success"> معتمد</span>

                                    </td>
                                    <td>
                                        <div class="optionbox">
                                            <select v-model="status_selected[index]" @change="change_status(
                                                index,
                                                delay.id,
                                                delay.sanction_date,
                                                delay.sanctionable.sanction,
                                                delay.sanctionable_id,
                                                delay.sanctionable_type
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

                                </tr>
                                <tr>
                                    <td colspan="3" style="color:red;font-size: x-large;">الاجمالي</td>

                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td align="center" colspan="3">لايوجد بياتات.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <pagination align="center" :data="delays" @pagination-change-page="list"></pagination> -->
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


   
            status_selected: [],

        };
    },
    mounted() {
        this.list();
        this.counts[0] = 1;
        this.type = 'delay_sanction';
    },
    methods: {

        list(page = 1) {
            this.axios
                .post(`/staff_delay_sanction?page=${page}`)
                .then(({ data }) => {

                    // console.log('mugib', data.list.data[0]);
                    this.value_list = data.list;

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
            ) {

            this.axios
                .post(`/change_status_delay_sanction`, {

                    sanctionable_id: sanctionable_id,
                    sanctionable_type: sanctionable_type,
                    staff: staff,
                    date: date,
                    sanction: sanction,
                    status: this.status_selected[index],

                })
                .then(({ data }) => {

                    toastMessage("تم التعديل بنجاح");                    // this.value_list = data.list;
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