<template>
    <div>
        <section class="content-header">
            <h1>
                條碼列印
                <small>Barcode</small>
            </h1>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="box">
                    <div class="box-body col-lg-offset-7">
        <div class="dataTables_wrapper form-inline dt-bootstrap">
            <input type="button" v-on:click="printBarcode()" value="列印"/>
            <input type="button" v-on:click="genrateBarcode()" value="產生"/>
            <input type="button" v-on:click="getBarcode()" value="取得資料"/>
            Total: {{ count }} <br>
            Backup: <input type="number" v-model="backup"/> <br>
            Title: <input type="text" size="30" v-model="title">
        </div>
        <div id="print_parts" style="height: 29.5cm; width: 21cm; position: absolute;left: 0;top: 0;bottom: 0;">
            <div v-for="i in count" style="height: 2.31cm; width: 4.17cm; float: left; text-align: center; padding-top: 0.16cm">
                <div style="font-size: 8px; text-align:center; -webkit-transform : scale(0.7);">{{ title }}</div>
                <svg style="border: solid 0.03cm #000;" v-bind:id="'barcode'+i" width="112" height="59"></svg>
            </div>
        </div>

    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                config: [],
                barcode: [],
                count: 0,
                backup: 10,
                title: 'MOPCON 場務組'
            }
        },
        computed: {},
        methods: {
            initConfig: function () {
//                var self = this;
//                self.config = {
//                    height: 29.7,
//                    width: 21,
//                    box_height: 2.48,
//                    box_width: 4.2,
//                }
            },
            printBarcode: function (printlist) {
                var value = $('#print_parts')[0].outerHTML;
                var printPage = window.open("", "Printing...", "");
                printPage.document.open();
                printPage.document.write("<HTML><head></head><BODY onload='window.print();window.close()'>");
                printPage.document.write(value);
                printPage.document.close("</BODY></HTML>");
            },
            genrateBarcode: function () {
                var self = this;
                for (var i = 1; i <= self.count; i++) {
                    JsBarcode('#barcode' + i, self.barcode[i-1].barcode, {
                        width: 1,
                        height: 30,
                        fontSize: 6,
                        text: self.barcode[i-1].barcode + "-" + self.barcode[i-1].display.slice(0, 10),
                    });
                }

            },
            getBarcode: function () {
                var self = this;
                axios.get(
                    '/api/barcode' + '?backup=' + self.backup
                ).then(response => {
                    var res = response.data.data;
                    self.barcode = res.barcode;
                    self.count = res.count;
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        created: function () {
            this.getBarcode();
//            this.initConfig();
        },
        watch: {}
    }
</script>
