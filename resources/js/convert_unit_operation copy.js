export default {


    methods: {
        change_price_cost_case_unit(i) {
            // --------------------------------------

            // carton -- baket  == carton/carton_rate*baket_rate
            //baket -- carton == baket/baket_rate*carton_rate
            // -----------------------------------------------------
            //carton -- pice ==  carton/carton_rate
            //baket -- pice ==  baket/baket_rate
            //pice -- carton == pice*carton_rate
            //pice -- baket == pice*baket_rate

            this.detail.forEach((element) => {
                element.units.forEach((unit) => {
                    // console.log(element.unit_id);

                    if (element.unit_id == 0) {
                        //this condition in case create new sale or new cash

                        console.log("rateeeeeee", unit.rate);
                        if (unit.rate == 1) {
                            element.unit_id = this.unit[i][0];
                            this.case_convert_into_small_unit(unit,i);
                            this.case_convert_into_bige_unit(unit,i);


                         
                        }
                    } else {
                        if (unit.unit_id == element.unit_id) {
                           
                            this.case_convert_into_small_unit(unit,i);

                            this.case_convert_into_bige_unit(unit,i);

                           

                            element.unit_id = this.unit[i][0];
                        }
                    }
                });
            });
        },
        case_convert_into_small_unit(unit,i) {
            if (unit.rate == 1 || this.unit[i][1] == 1) {
                // ------------------------------------------------------------------------------------------------------

                if (unit.rate > this.unit[i][1]) {
                    console.log(
                        "unit.rate == 1 || this.unit[i][1] == 1-----------unit.rate > this.unit[i][1]",
                        unit.rate,
                        this.unit[i][1]
                    );

                    if (this.unit_price[i]) {
                        this.unit_price[i] = this.unit_price[i] / unit.rate;
                    }

                    this.unit_cost[i] = this.unit_cost[i] / unit.rate;
                }
                // ------------------------------------------------------------------------------------------------------
                if (unit.rate < this.unit[i][1]) {
                    console.log(
                        "unit.rate == 1 || this.unit[i][1] == 1------------unit.rate < this.unit[i][1]",
                        unit.rate,
                        this.unit[i][1]
                    );

                    if (this.unit_price[i]) {
                        this.unit_price[i] =
                            this.unit_price[i] * this.unit[i][1];
                    }

                    this.unit_cost[i] = this.unit_cost[i] * this.unit[i][1];
                }
            }
        },
        case_convert_into_bige_unit(unit,i) {
            if (unit.rate != 1 && this.unit[i][1] != 1) {
                // ------------------------------------------------------------------------------------------------------

                if (unit.rate > this.unit[i][1]) {
                    console.log(
                        "unit.rate != 1 && this.unit[i][1] != 1------------unit.rate > this.unit[i][1]",
                        unit.rate,
                        this.unit[i][1]
                    );

                    if (this.unit_price[i]) {
                        //this condition in case new sale

                        this.unit_price[i] =
                            (this.unit_price[i] / unit.rate) * this.unit[i][1];
                    }

                    if (this.unit_cost[i]) {
                        this.unit_cost[i] =
                            (this.unit_cost[i] / unit.rate) * this.unit[i][1];
                    }
                }
                // ------------------------------------------------------------------------------------------------------

                if (unit.rate < this.unit[i][1]) {
                    console.log(
                        "unit.rate != 1 && this.unit[i][1] != 1------------unit.rate < this.unit[i][1]",
                        unit.rate,
                        this.unit[i][1]
                    );

                    if (this.unit_price[i]) {
                        this.unit_price[i] =
                            (this.unit_price[i] / unit.rate) * this.unit[i][1];
                    }

                    if (this.unit_cost[i]) {
                        this.unit_cost[i] =
                            (this.unit_cost[i] / unit.rate) * this.unit[i][1];
                    }
                }
            }
        },
      
    },
};
