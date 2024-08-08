new Vue({
    el: '#tab-agency',

    data: {
        agencycode: '', erragencycode: false, msgagencycode: 'This field is required.',
        agencydesc: '', erragencydesc: false, codes: [],
        acctcode: '', erracctcode: false, error: true, code: $('#txtcode').val()
    },

    mounted() {
        if(this.code != ''){
            this.fetchDeductionData();
        }else{
            this.fetchData('../libraries/deductions/fetchAgency');
        }
    },

    watch: {
        'agencydesc': function(val){ this.erragencydesc = (val == '') ? true: false; this.checkError();},
        'acctcode': function(val){ this.erracctcode = (val == '') ? true: false; this.checkError();},
        'agencycode': function(val){
            if(val == ''){
                this.erragencycode = true;
            }else{
                for(var i = 0; i < this.codes.length; i++) {
                    if(this.codes[i].deductionGroupCode.toLowerCase().trim() == val.toLowerCase().trim()) {
                        this.msgagencycode = 'Deduction Code must be unique.'; this.erragencycode = true; break;
                    }else{
                        this.erragencycode = false;
                    }
                }
            }
            this.checkError();
        },
    },

    methods: {
        fetchData: function(url) { axios.get(url).then(function (response) { this.codes = response.data; }.bind(this)); },
        checkError: function() { this.error = ([this.erragencydesc, this.erragencycode, this.erracctcode].includes(true) || [this.agencycode, this.agencydesc, this.acctcode].includes('')) ? true : false; },
        fetchDeductionData: function() {
            axios.get('../../libraries/deductions/fetchAgencyData/'+this.code).then(function (response) {
                this.agencycode = response.data[0].deductionGroupCode;
                this.agencydesc = response.data[0].deductionGroupDesc;
                this.acctcode = response.data[0].deductionGroupAccountCode;
            }.bind(this));
        }
    }
});