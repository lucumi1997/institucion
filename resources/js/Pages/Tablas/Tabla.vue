<template>
  <div id="example-table" ref="table"
    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"></div>
</template>

<script>
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { TabulatorFull as Tabulator } from 'tabulator-tables';

const tableData = ref();
const tabulator = ref();

export default {
  data() {
    return {
      tabulator: null,

    }
  },

  mounted() {
    this.listEstudiantes()
  },
  methods: {

    listEstudiantes() {

      axios.get('/estudiantesapi').then(function (response) {
        tableData.value = response.data[0];

        tabulator.value = new Tabulator("#example-table", {
          data: tableData.value,
          ajaxFiltering: true,
          ajaxSorting: true,
          printAsHtml: true,
          printStyled: true,
          pagination: "local",
          paginationSize: 10,
          paginationSizeSelector: [10, 20, 30, 40],
          layout: "fitColumns",
          responsiveLayout: "collapse",
          placeholder: "No matching records found",
          columns: [
            {
              formatter: "responsiveCollapse",
              width: 40,
              minWidth: 30,
              hozAlign: "center",
              resizable: false,
              headerSort: false,

            },
            {
              title: "Nombres",
              editorParams: {
                search: true,
                mask: "AAA-999",
                selectContents: true,
                elementAttributes: {
                  maxlength: "10", //set the maximum character length of the input element to 10 characters
                }
              },
              headerFilter: "input",
              minWidth: 200,
              responsive: 0,
              field: "name",
              vertAlign: "middle",
              print: false,
              download: false,
   
              formatter(cell) {
                return `<div>
                <div class="font-medium whitespace-nowrap"></div>
                <div class="text-slate-800 text-md whitespace-nowrap">${cell.getData().name
                  }</div>
              </div>`;
              },
            },
            {
              title: "Apellidos",
              minWidth: 200,
              responsive: 0,
              field: "lastname",
              vertAlign: "middle",
              print: false,
              download: false,
              formatter(cell) {
                return `<div>
                <div class="font-medium whitespace-nowrap"></div>
                <div class="text-slate-800 text-md whitespace-nowrap">${cell.getData().lastname
                  }</div>
              </div>`;
              },
            },
            {
              title: "Edad",
              minWidth: 200,
              responsive: 0,
              field: "age",
              vertAlign: "middle",
              print: false,
              download: false,
              formatter(cell) {
                return `<div>
                <div class="font-medium whitespace-nowrap"></div>
                <div class="text-slate-800 text-md whitespace-nowrap">${cell.getData().age
                  }</div>
              </div>`;
              },
            },
            {
              title: "Género",
              minWidth: 200,
              responsive: 0,
              field: "gender",
              vertAlign: "middle",
              print: false,
              download: false,
              formatter(cell) {
                return `<div>
                <div class="font-medium whitespace-nowrap"></div>
                <div class="text-slate-800 text-md whitespace-nowrap">${cell.getData().gender
                  }</div>
              </div>`;
              },
            },
            {
              title: "Editar",
              minWidth: 200,
              responsive: 0,
              field: "editar",
              vertAlign: "middle",
              print: false,
              download: false,
              cellClick: function (e, cell) {
                alert(cell.getData().id)
              },
              formatter(cell) {
                return `<div>
                <div class="font-medium whitespace-nowrap"></div>
                <button
                 type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Editar</button>
              </div>`;
              },
            },

          ],
          renderComplete() {
            createIcons({
              icons,
              "stroke-width": 1.5,
              nameAttr: "data-lucide",
            });
          },
        });
      });
    },
  },
  editEstudiantes(id) {
    console.log(id)
  }
}
</script>