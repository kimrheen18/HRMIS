new Vue({
    el: '#signatory',

    data: {
        sigpgcode: '', errsigpgcode: false,
        sigsignatory: '', errsigsignatory: false,
        sigposition: '', errsigposition: false,
        error: true, code: $('#txtcode').val()
    },

    mounted() {
        if(this.code != ''){
            this.fetchSignatoryData();
        }
    },

    watch: {
        'sigpgcode': function(val){ this.errsigpgcode = (val == '') ? true: false; this.checkError();},
        'sigsignatory': function(val){ this.errsigsignatory = (val == '') ? true: false; this.checkError();},
        'sigposition': function(val){ this.errsigposition = (val == '') ? true: false; this.checkError();}
    },

    methods: {
        checkError: function() { this.error = ([this.errsigpgcode,this.errsigsignatory,this.errsigposition].includes(true) || [this.sigpgcode,this.sigsignatory,this.sigposition].includes('')) ? true : false; },
        fetchSignatoryData: function() {
            axios.get('../../libraries/signatory/fetchSignatoryData/'+this.code).then(function (response) {
                this.sigpgcode = response.data[0].payrollGroupCode;
                this.sigsignatory = response.data[0].signatory;
                this.sigposition = response.data[0].signatoryPosition;
            }.bind(this));
        }
    }
});