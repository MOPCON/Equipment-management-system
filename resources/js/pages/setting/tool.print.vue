<template>
    <div>
        <h1>
            條碼列印
            <small>Barcode</small>
        </h1>
        <div class="container-fluid">
            <div class="mb-3">
                <input type="button" v-on:click="printBarcode()" value="列印"/>
                <input type="button" v-on:click="genrateBarcode()" value="產生"/>
                <input type="button" v-on:click="getBarcode()" value="取得資料"/>
                Total: {{ count }} <br>
                Backup: <input type="number" v-model="backup"/> <br>
                Title: <input type="text" size="30" v-model="title">
            </div>
            <div id="print_parts"
                 style="height: 29.5cm; width: 21cm; left: 0;top: 0;bottom: 0;">
                <div v-for="i in count"
                     style="height: 2.31cm; width: 4.17cm; float: left; text-align: center; padding-top: 0.16cm">
                    <div style="font-size: 8px; text-align:center; -webkit-transform : scale(0.7);">{{ title
                        }}
                    </div>
                    <svg style="border: solid 0.03cm #000;" v-bind:id="'barcode'+i" width="112"
                         height="59"></svg>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import jsbarcode from 'jsbarcode';
    export default {
        data() {
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
            printBarcode() {
                const value = $('#print_parts')[0].outerHTML;
                const printPage = window.open("", "Printing...", "");
                printPage.document.open();
                printPage.document.write("<HTML><head></head><BODY onload='window.print();window.close()'>");
                printPage.document.write(value);
                printPage.document.close("</BODY></HTML>");
            },
            genrateBarcode() {
                const self = this;
                for (let i = 1; i <= self.count; i++) {
                    JsBarcode('#barcode' + i, self.barcode[i - 1].barcode, {
                        width: 1,
                        height: 30,
                        fontSize: 6,
                        text: self.barcode[i - 1].barcode + "-" + self.barcode[i - 1].display.slice(0, 10),
                    });
                }

            },
            getBarcode() {
                const self = this;
                axios.get(
                    '/api/barcode' + '?backup=' + self.backup
                ).then(response => {
                    const res = response.data.data;
                    self.barcode = res.barcode;
                    self.count = res.count;
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.getBarcode();
        },
        watch: {}
    }
</script>
