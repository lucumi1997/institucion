<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

import { ref } from 'vue'
import { Dialog, DialogDescription, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'

const eliminar = () => {
    Swal.fire({
        title: '¿Está seguro de eliminar el estudiante?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        confirmButtonColor: '#6EE7B7',
        cancelButtonText: `Cancelar`,
    }).then((result) => {
        let data = new FormData();
        data.append('id', miestudiante_id.value);
        if (result.isConfirmed) {
            console.log(miestudiante_id.value);

            axios.post('/eliminarestudiante', data)
                .then((res) => {
                    if (res.data.ejecucion == true) {
                        Swal.fire("Exito", res.data.success, "success");
                        ejecucciones.value = true;

                    }

                })

        }
    })
}

</script>

<style>
/*@import 'datatables.net-dt';*/
</style>
<script>

import { onMounted, ref } from 'vue';
import router from '../../router/index'

/**SELECT ***/
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import { TabulatorFull as Tabulator, TabulatorFull } from 'tabulator-tables';

const tableData = ref();
const tabulator = ref();

const miopen = ref(false);


/**SELECT ***/


const table = ref();
const misestu = ref();
const data = ref([]);
const estado = ref();
const errors = ref();
const jsonerrors = ref();
const mostrarerrores = ref(0);
const open = ref(false);
const miestudiante_id = ref();
const miestudiantes = [
    { name: '' },
    { lastname: '' },
    { age: '' },
    { gender: '' },
]
const ejecucciones = ref(false);
export default {
    props: ["estudiante", "estudiante_id"],
    data() {
        return {
            estudiantes: {
                name: "",
                lastname: "",
                age: "",
                gender: "",
            },
            select: false,

        };
    },
    mounted() {
        this.listEstudiantes()
    },
    created() {
    },
    updated() {
    },
    destroyed() {
    },
    methods: {
        submit(e) {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let midata = new FormData();
            midata.append("name", this.estudiantes.name);
            midata.append("lastname", this.estudiantes.lastname);
            midata.append("age", this.estudiantes.age);
            midata.append("gender", this.estudiantes.gender);
            const res = axios.post("/estudiantes", midata, config).then(function (response) {
                if (response.data.ejecuccion == true) {
                    // console.log(response.data);
                    estado.value = response.data.ejecuccion;
                    Swal.fire("¡Guardado correctamente!", "", "success");
                    resetForm();
                }
                else {
                    Swal.fire("¡Lo sentimos, no se pudo guardar!", "", "error");
                }
                if (estado.value == true) {
                    /* data.value.push({
                         name: response.data[0].name,
                         lastname: response.data[0].lastname,
                         age: response.data[0].age,
                         gender: response.data[0].gender,
                         acciones: columns[5].campo
                     });*/
                }
                else {
                    Swal.fire("¡Lo sentimos, no se pudo guardar!", "", "error");
                }

            }).catch(function (err) {
                console.log(err);
                if (err.response) {
                    mostrarerrores.value = 1;
                    if (err.response.data.errors.name) {
                        errors.value = jsonerrors.value = ({
                            name: err.response.data.errors.name[0],
                        });
                    }
                    else if (err.response.data.errors.lastname) {
                        errors.value = jsonerrors.value = ({
                            lastname: err.response.data.errors.lastname[0],
                        });
                    }
                    else if (err.response.data.errors.age) {
                        errors.value = jsonerrors.value = ({
                            age: err.response.data.errors.age[0],
                        });
                    }
                    else /*(err.response.data.errors.gender)*/ {
                        errors.value = jsonerrors.value = ({
                            gender: err.response.data.errors.gender[0],
                        });
                    }
                }
            });
            let resetForm = () => {
                this.name = "";
                this.lastname = "";
                this.age = "";
            };
            this.listEstudiantes();
        },
        updateEstudiante(e) {
            e.preventDefault();
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('id', miestudiante_id.value);
            data.append('name', miestudiantes[0].name);
            data.append('lastname', miestudiantes[0].lastname);
            data.append('age', miestudiantes[0].age);
            data.append('gender', miestudiantes[0].gender);
            axios
                .post('/actualizarestudiante/', data, config)
                .then((res) => {
                    console.log(miestudiante_id.value)
                    midis.success = res.data.success;
                    midis.ejecucion = res.data.ejecucion;
                    console.log(midis.success);
                    console.log(midis.ejecucion);
                    if (midis.ejecucion == true) {
                        Swal.fire("Exito", "Actualizado correctamente", "success");
                        this.listEstudiantes()
                    }
                    open.value = false

                });
        },
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
                    replaceData: true,
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
                            width: 83,
                            responsive: 0,
                            field: "editar",
                            vertAlign: "middle",
                            print: false,
                            download: false,
                            cellDblClick: function (e, cell) {
                                axios.get('/editarestudiante/' + cell.getData().id)
                                    .then((res) => {
                                        open.value = true;
                                        miestudiante_id.value = cell.getData().id;
                                        miestudiantes[0].name = res.data[0].name
                                        miestudiantes[0].lastname = res.data[0].lastname
                                        miestudiantes[0].age = res.data[0].age
                                        miestudiantes[0].gender = res.data[0].gender
                                        console.log(miestudiantes[0])
                                    })
                            },
                            formatter(cell) {
                                return `<div>
          <div class="font-medium whitespace-nowrap"></div>
          <button
           type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Editar</button>
        </div>`;
                            },
                        },
                        {
                            title: "Eliminar",
                            width: 100,
                            responsive: 0,
                            field: "eliminar",
                            vertAlign: "middle",
                            print: false,
                            download: false,
                            cellDblClick: function (e, cell) {
                                miestudiante_id.value = cell.getData().id;

                            },
                            formatter(cell) {
                                return `<div>
          <div class="font-medium whitespace-nowrap"></div>
          <button
           type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Eliminar</button>
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
                })

            })
        },

    },

}

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="mx-auto m-10 max-w-7xl">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Estudiantes</h3>
                        <p class="mt-1 text-sm text-gray-600">Crea estudiantes con todos sus datos.</p>
                    </div>
                </div>
                <div class="mt-5 md:col-span-2 md:mt-0">
                    <form id="formulario" @submit.prevent="submit" method="POST">
                        <div class="shadow sm:overflow-hidden sm:rounded-md">
                            <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="name"
                                                class="block text-sm font-medium text-gray-700">Nombre</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" v-model="estudiantes.name" id="name"
                                                    class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    placeholder="" />
                                            </div>
                                            <div v-if="mostrarerrores == 1" class="col-span-3 sm:col-span-2">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="lastname"
                                                class="block text-sm font-medium text-gray-700">Apellido</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" v-model="estudiantes.lastname" id="lastname"
                                                    class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    placeholder="" />
                                            </div>
                                            <div v-if="mostrarerrores == 1" class="col-span-3 sm:col-span-2">
                                                {{ errors.lastname }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="age"
                                                class="block text-sm font-medium text-gray-700">Edad</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <input type="text" v-model="estudiantes.age" id="age"
                                                    class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    placeholder="" />

                                            </div>
                                            <div v-if="mostrarerrores == 1" class="col-span-3 sm:col-span-2">
                                                {{ errors.age }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="gender"
                                                class="block text-sm font-medium text-gray-700">Género</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <select id="country" v-model="estudiantes.gender"
                                                    autocomplete="country-name" required
                                                    class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                    <option selected value="">Seleccione</option>
                                                    <option value="Masculino">Masculino</option>
                                                    <option value="Femenino">Femenino</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </div>
                                            <div v-if="mostrarerrores == 1" class="col-span-3 sm:col-span-2">
                                                {{ errors.gender }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                            <button type="submit"
                                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="mx-auto m-10 max-w-7xl">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4">
                    <div id="example-table" ref="table"
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"></div>
                </div>

            </div>
        </div>
        <div>
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-10" @close="open = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                        enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="grid justify-items-center fixed z-10 inset-0 overflow-y-auto">
                        <div
                            class="flex items-end sm:items-center  justify-center max-w-5xl min-h-full p-4 text-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">


                                <DialogPanel
                                    className="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                                    <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div className="sm:flex sm:items-start">
                                            <div className="mt-12 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3"
                                                    className="text-lg mt-3 leading-6 font-medium text-gray-900">
                                                    Crear productos
                                                </DialogTitle>
                                                <div className="mt-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="bg-gray-50 px-4 py-3 sm:px-6">
                                        <div className="md:grid md:grid-cols-2 md:gap-6">
                                            <div className="mt-5 md:mt-0 md:col-span-2">
                                                <form @submit="updateEstudiante">
                                                    <div className="shadow sm:rounded-md sm:overflow-hidden">
                                                        <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                            <div className="flex gap-6">

                                                                <div className="w-full">
                                                                    <label htmlFor="titulo"
                                                                        className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre</label>
                                                                    <input type="text" id="titulo"
                                                                        v-model="miestudiantes[0].name"
                                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        placeholder="" required />
                                                                </div>

                                                                <div className="w-full">
                                                                    <label htmlFor="pos_color"
                                                                        className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Apellidos</label>
                                                                    <input type="text"
                                                                        v-model="miestudiantes[0].lastname"
                                                                        id="pos_color"
                                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        required />
                                                                </div>

                                                                <div className="w-full">
                                                                    <label htmlFor="titulo"
                                                                        className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Edad</label>
                                                                    <input type="text" id="titulo"
                                                                        v-model="miestudiantes[0].age"
                                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                        placeholder="" required />
                                                                </div>

                                                                <div className="w-full">
                                                                    <label htmlFor="pos_color"
                                                                        className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Género</label>
                                                                    <div class="mt-1 flex rounded-md shadow-sm">

                                                                        <select id="country"
                                                                            v-model="miestudiantes[0].gender"
                                                                            autocomplete="country-name" required
                                                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                                            <option selected value="">Seleccione
                                                                            </option>
                                                                            <option value="Masculino">Masculino</option>
                                                                            <option value="Femenino">Femenino</option>
                                                                            <option value="Otro">Otro</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div className="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                                            <button type="submit"
                                                                className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-indigo-700">
                                                                Guardar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div className="bg-gray-50 px-4 py-3 sm:px-6">

                                        </div>
                                    </div>
                                </DialogPanel>


                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </div>
    </AppLayout>

</template>

