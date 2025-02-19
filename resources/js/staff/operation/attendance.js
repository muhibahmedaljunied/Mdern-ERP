export default {
    data() {
        return {
            date: new Date().toISOString().substr(0, 10),
            dateselected: new Date().toISOString().substr(0, 10),
            expiry_date: new Date().toISOString().substr(0, 10),

            value_list: {
                type: Object,
                default: null,
            },
            staff_attendance: {
                type: Object,
                default: null,
            },

            attendance_type: 1,
            attendance_date: new Date().toISOString().substr(0, 10),
            attendance_final: "pendding",
            show: true,
            sort: [],
            period: [],
            staff_selected: [],
            time_checkin: [],
            time_checkout: [],
            status: [],
            check_in: [],
            check_out: [],
            time_in: [],
            time_out: [],
            check_attend: [],
            duration: [],
            delay: [],
            leaveout: [],
            extra: [],
            extra_after: [],
            check_state: [],
            date: [],
            staff: [],

            work_type_selected: "",
            staff_search: "",
            attendance_in_out: "",
            work_selected: "",
            period_selected: "",
            period_times: "",
            work_types: "",
            work_system_types: "",
        };
    },
    methods: {
        init_attendance(list) {
            for (let index = 0; index < list.data.length; index++) {
                const element = list.data[index];

                if (element.period.length == 0) {
                    this.check_in[index] = element.from_time;
                    this.check_out[index] = element.into_time;
                } else {
                    element.period.forEach((ele) => {
                        if (ele.attendance_status == 0) {
                            this.check_in[index] = element.from_time;
                            this.check_out[index] = element.into_time;
                        }

                        if (ele.attendance_status == 1) {
                            this.check_in[index] = ele.check_in;
                            this.check_out[index] = ele.check_out;
                        }
                    });
                }
            }
        },

        get_time_for_all_staff() {
            axios
                .post(`/attendance/get_time`, {
                    date: this.attendance_date,
                    work_system_id: this.work_selected,
                    period_id: this.period_selected,
                })
                .then(({ data }) => {
                    //get_time_for_current_period
        
                        this.value_list = data.periods;

                        this.init_attendance(data.periods);
                    }
                );
        },

        translate_time(index, time, h, m, type) {
            // console.log('translate_time', index, time, h, m, type);

            if (time % 60 == 0) {
                $(`#attendance_${type}${index}`).val(`${h}ساعه`);
            }
            if (time == 0) {
                $(`#attendance_${type}${index}`).val(0);
            }
            if (time < 60 && time > 0) {
                $(`#attendance_${type}${index}`).val(`${m}دقيقه`);
            }

            if (time > 60 && time % 60 != 0) {
                $(`#attendance_${type}${index}`).val(`${h}ساعه,${m}دقيقه`);
            }

            $(`#attendance_${type}_hidden${index}`).val(m + h * 60);
        },
        calc_time(index, from, into) {
            var time, mm, hh;
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;

            var split_in;
            var split_out;
            var date1;
            var date2;
            var date;

            this.check_in[index] = $(`#in${index}`).val();
            this.check_out[index] = $(`#out${index}`).val();
            split_in = this.check_in[index].split(":");
            split_out = this.check_out[index].split(":");

            date = this.attendance_date.split("-");
            date1 = new Date(
                date[0],
                date[1],
                date[2],
                split_in[0],
                split_in[1]
            ); // 9:00 AM
            date2 = new Date(
                date[0],
                date[1],
                date[2],
                split_out[0],
                split_out[1]
            ); // 5:00 PM

            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }

            [time, mm, hh] = this.get_diff(date1, date2);
            (time_result += time), (mm_result += mm), (hh_result += hh);

            this.duration[index] = time_result;

            this.translate_time(
                index,
                time_result,
                hh_result,
                mm_result,
                "duration"
            );

            this.calc_delay(index, from, into);
            this.calc_leaveout(index, from, into);
            this.calc_extra_before(index, from, into);
            this.calc_extra_after(index, from, into);

            // console.log('----------', split_in, split_out);
        },

        calc_delay(index, from, into) {
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(
                index,
                "from",
                from,
                into,
                "delay"
            );
            // console.log('delay', time_result, hh_result, mm_result);
            this.delay[index] = time_result;
            this.translate_time(
                index,
                time_result,
                hh_result,
                mm_result,
                "delay"
            );
        },
        calc_extra_before(index, from, into) {
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(
                index,
                "from",
                from,
                into,
                "extra"
            );
            this.extra[index] = time_result;
            this.translate_time(
                index,
                time_result,
                hh_result,
                mm_result,
                "extra"
            );
        },

        calc_extra_after(index, from, into) {
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(
                index,
                "into",
                from,
                into,
                "extra_s"
            );
            this.extra_after[index] = time_result;
            this.translate_time(
                index,
                time_result,
                hh_result,
                mm_result,
                "extra_s"
            );
        },
        calc_leaveout(index, from, into) {
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;
            [time_result, hh_result, mm_result] = this.loop_data(
                index,
                "into",
                from,
                into,
                "leaveout"
            );
            this.leaveout[index] = time_result;
            this.translate_time(
                index,
                time_result,
                hh_result,
                mm_result,
                "leaveout"
            ); // if (time_result % 60 == 0) {
        },

        loop_data(index, type, from, into, x) {
            var time_result = 0,
                mm_result = 0,
                hh_result = 0;
            var time = 0,
                mm = 0,
                hh = 0;
            var date1, date2;
            var split_in, split_out;
            // for (const key in period) {

            //     if (Object.prototype.hasOwnProperty.call(period, key)) {

            [split_in, split_out] = this.splite_time(index, type, from, into);
            [date1, date2] = this.get_date(split_in, split_out);
            // console.log('loop_data', x, split_in, split_out);

            if (x == "delay" && type == "from") {
                if (split_in < split_out) {
                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {
                    time, mm, (hh = 0);
                }
            }

            if (x == "leaveout" && type == "into") {
                if (split_in > split_out) {
                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {
                    time, mm, (hh = 0);
                }
            }

            if (x == "extra" && type == "from") {
                if (split_in > split_out) {
                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {
                    time, mm, (hh = 0);
                }
            }

            if (x == "extra_s" && type == "into") {
                if (split_in < split_out) {
                    [time, mm, hh] = this.get_diff(date1, date2);
                } else {
                    time = 0;
                    mm = 0;
                    hh = 0;
                }
            }

            (time_result += time), (mm_result += mm), (hh_result += hh);

            //     }

            // }
            // console.log('delay', time_result, hh_result, mm_result);

            return [time_result, hh_result, mm_result];
        },

        splite_time(index, type, from, into) {
            var split_out;
            var split_in;
            if (type == "from") {
                split_in = from.split(":");
                split_out = this.check_in[index].split(":");
            } else {
                split_in = into.split(":");
                split_out = this.check_out[index].split(":");
            }

            return [split_in, split_out];
        },
        get_date(split_in, split_out) {
            var date1, date2, date;
            var split_in;
            var split_out;
            var date;

            date = this.attendance_date.split("-");
            date1 = new Date(
                date[0],
                date[1],
                date[2],
                split_in[0],
                split_in[1]
            ); // 9:00 AM
            date2 = new Date(
                date[0],
                date[1],
                date[2],
                split_out[0],
                split_out[1]
            ); // 5:00 PM

            return [date1, date2];
        },
        get_diff(date1, date2) {
            var diff = 0;
            if (date1 < date2) {
                diff = date2 - date1;
            } else {
                diff = date1 - date2;
            }

            // ---------------------
            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var ss = Math.floor(msec / 1000);
            msec -= ss * 1000;

            var time = mm + hh * 60;

            if (mm == 0) {
                time = hh * 60;
            }
            if (hh == 0) {
                time = mm;
            }

            return [time, mm, hh];
        },
    },
};
