export default {
    data() {
        return {
            value_list: {
                type: Object,
                default: null,
            },
            dateselected:'',
            check_state: [],
            apply_date: "",
            discounttypeselected: [],
            discountselected: [],
            sanctionselected: [],
            count: 1,
            counts: {},
            staffselected: [],
            staff_selected: [],
            word_search: "",
            type: "",
            staffs: "",
            // -------------------------------------------------
            work_systems: "",
            staff_on_change: "",
            extra_ypes: "",
            vactions: "",
            jobs: "",
            branches: "",
            staff_types: "",
            vacation_types: "",
            branchselected: "",
            staff_allowances: "",
            salaryselected: 0,
            allowances: "",
            staff_id: "",
            salary: "",
            iterations: "",
            iterationselected: [],
        };
    },
    methods: {
        Add(data) {
            // alert(this.type);

            // console.log(data);
            this.axios.post(`/store_${this.type}`, data).then((response) => {
                console.log(response);
                toastMessage("تم الاضافه بنجاح");
                // this.$router.go(0);
            });

            // this.$router.go(0);
        },

        select_staff() {
            console.log(this.staff_selected);
            this.axios
                .post(`/${this.table}/select_staff`, {
                    id: this.staff_selected,
                })
                .then(({ data }) => {
                    console.log(data);
                    this.list_data = data.list;
                });
        },
        select_staff() {
            console.log(this.staff_selected);
            this.axios
              .post(`/${this.table}/select_staff`, {
           
                id: this.staff_selected,
      
              })
              .then(({ data }) => {
                console.log(data);
                this.list_data = data.list;
              });
          },
        delete(id) {
            this.axios
                .post(`delete_${this.table}/${id}`)
                .then((response) => {
                    toastMessage("تم الحذف بنجاح");

                    this.list();
                    // this.$router.push('category')
                })
                .catch((error) => {
                    console.log(error.response);

                    if (error.response.status == 500) {
                        toast.fire({
                            title: " فشل",
                            text: error.response.data.message,
                            button: "Close", // Text on button
                            icon: "error", //built in icons: success, warning, error, info
                            timer: 5000, //timeOut for auto-close
                            buttons: {
                                confirm: {
                                    text: "OK",
                                    value: true,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                },
                                cancel: {
                                    text: "Cancel",
                                    value: false,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                },
                            },
                        });
                    }
                });
        },
        apply(sanction, staff_id) {
            axios
                .post(`/apply_${this.type}_sanction_attendance`, {
                    sanction: sanction,
                    staff_id: staff_id,
                    date: this.apply_date,
                })
                .then((response) => {});
        },

        addComponent(index) {
            // alert(index);
            this.count += 1;
            this.counts[index] = this.count;
        },
        disComponent(index) {
            this.count -= 1;
            this.$delete(this.counts, index);
        },
    },
};
