<template>
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <span class="h2"> الوحدات</span>


      </div>

      <div class="card-body">
        <div class="card">


          <div class="card-body">
            <div class="row row-sm">
              <div class="col-xl-12">
                <div class="card">

                  <div class="card-body">
                    <form method="post" enctype="multipart/form-data">

                      <div class="table-responsive">
                        <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-large">
                          <thead>
                            <tr>

                              <th> الوحده</th>







                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">
                              <td>
                                <input v-model="unit[index]" type="text" class="form-control" name="name" id="name"
                                  required />

                              </td>





                              <td v-if="index == 1">
                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                                  <i class="fa fa-plus-circle"></i></a>

                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                                  <i class="fa fa-minus-circle"></i></a>
                              </td>



                            </tr>

                            <tr>
                              <td></td>
                              <td>
                                <button type="button" class="btn btn-primary" @click="addunit()">حفظ </button>

                              </td>
                            </tr>

                          </tbody>
                        </table>
                      </div>
                    </form>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <!-- <span class="h2"> الموردين</span> -->

            <div style="display: flex;float: left; margin: 5px">


              <button @click="exports_excel()">

                <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
              </button>

              <button @click="imports_excel()">

                <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث " v-model="word_search"
                @input="get_search()" />
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">الوحده</th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="units && units.length > 0">
                  <tr v-for="(unit, index) in units" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ unit.name }}</td>



                    <td>
                      <button type="button" @click="delete_unit(unit.id)" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>
                      <router-link :to="{ name: 'edit_unit', params: { id: unit.id } }" class="btn btn-success"><i
                          class="fa fa-edit"></i></router-link>
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
            <pagination align="center" :data="units" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>



  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../js/operation.js';
export default {
  mixins: [operation],
  components: {
    pagination,
  },
  data() {
    return {
      //   unit: "yes",

      units: {
        type: Object,
        default: null,
      },

      unit: [],
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
  },
  methods: {
    delete_unit(id) {
      this.axios.post(`/delete_unit/${id}`).then((response) => {
        // this.$router.push('unit')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/unitsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.units = data.units;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/unit?page=${page}`)
        .then(({ data }) => {
          this.units = data.units;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    addunit() {


      this.axios
        .post("/store_unit", {

          count: this.counts,
          name: this.unit


        })
        .then(function (response) {

          toastMessage("تم الاضافه بنجاح");
          this.list();

        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);

    },

    exports_excel() {

      axios
        .post(`export_store`)
        .then(function (response) {

          toastMessage("تم تصدير   ");
          console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_store`)
        .then(function (response) {

          toastMessage("تم استيراد   ");

        })
        .catch(error => {

        });
    },
  },
};
</script>