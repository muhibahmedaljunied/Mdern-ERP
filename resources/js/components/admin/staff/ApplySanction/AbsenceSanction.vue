<template>


    <div class="content container-fluid">



        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            <span class="h4">تطبيق لوائح الغياب</span>
                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-2">
                                <label for="status"> نوع الغياب</label>

                                <select v-model="absenceselected" name="type" class="form-control " required>
                                    <option v-for="absence in absence_types" v-bind:value="absence.id">
                                        {{ absence.name }}
                                    </option>
                                </select>

                            </div>

                            <!-- <div class="col-md-2">
                                <label for="status">عدد المرات</label>
                                <select v-model="iterationselected" class="form-control " required>
                                    <option v-for="iteration in iterations" v-bind:value="iteration.id">
                                        {{ iteration.name }}
                                    </option>
                                </select>
                            </div> -->
                            <!-- <div class="col-md-2">
                                <label for="status">نظام العمل</label>
                                <select @change="get_period(work_selected)" v-model="work_selected" name="type"
                                    class="form-control " required>
                                    <option v-for="work_system in work_system_types" v-bind:value="work_system.id">
                                        {{ work_system.name }}
                                    </option>
                                </select>




                            </div> -->

                            <!--<div class="col-md-2">
                                <label for="status"> الفتره</label>
                                <select id='select_period' v-model="period_selected" name="type" class="form-control "
                                    required>

                                </select>
                            </div> -->

                            <!-- <div class="col-md-2">
                                <label for="status"> التأريخ</label>
                                <input class="form-control" type="date" name="" id="" v-model="attendance_date">


                            </div> -->

                            <div class="col-sm-6 col-md-2" style="margin-top: auto;">


                                <a @click="search()" id="agregar_productos" data-target=".bs-example-modal-sm">
                                    <img src="/assets/img/search.png" alt="" style="width: 15%;"></a>
                            </div>



                        </div>




                    </div>


                </div>
            </div>
        </div>


        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-body" id="printme">


                        <form action="post">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>

                                            <th class="wd-10p border-bottom-0">اسم المؤظف</th>
                                            <th class="wd-10p border-bottom-0">نوع الغياب</th>
                                            <th class="wd-10p border-bottom-0">عدد المرات</th>


                                            <th class="wd-10p border-bottom-0"> اللائحه </th>




                                        </tr>
                                    </thead>
                                    <tbody v-if="value_list && value_list.data.length > 0">
                                        <tr v-for="(staff, indexs) in value_list.data" :key="indexs">



                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>



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
                            <!-- <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                  العمليه</span></a> -->
                        </form>
                        <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
                    </div>


                </div>
            </div>
        </div>



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



            absence_types: '',
            absenceselected: [],




        };
    },
    mounted() {
        this.list();
        this.type = 'attendance';
    },
    methods: {


        list(page = 1) {
            this.axios
                .post(`/absence_sanction?page=${page}`)
                .then(({ data }) => {


                    this.absence_types = data.absence_types;
                    this.iteration = data.iteration;
                    this.value_list = data.list;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        search() {

            axios.post(`/absence_sanction/show`, {
                absence_type: this.absenceselected,
            }).then(
                (response) => {

                    this.value_list = response.data.periods;



                });
        },

    },
};
</script>
