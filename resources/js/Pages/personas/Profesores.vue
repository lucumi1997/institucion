<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import axios from 'axios';
import Swal from 'sweetalert2';


</script>


<style>
/*@import 'datatables.net-dt';*/
</style>
<script>

import { onMounted, ref } from 'vue';
import DataTable from 'datatables.net-vue3';
import Select from 'datatables.net-select';
import DataTableBs5 from 'datatables.net-bs5';
import { TabulatorFull as Tabulator } from 'tabulator-tables';
import router from '../../router/index'
const table = ref();
const misestu = ref();
const data = ref([]);
const tableData = ref();
const estado = ref();
const errors = ref();
const jsonerrors = ref();
const mostrarerrores = ref(0);

DataTable.use(Select);
/**SELECT ***/
import {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
const courses = [
    { name: 'Matematicas' },
    { name: 'Física' },
    { name: 'Lenguaje' },
    { name: 'Etica' },
    { name: 'Religión' },
    { name: 'Democracia' },
    { name: 'Biología' },
]
const selectedCourse = ref(courses[0])
/**SELECT ***/




const columns = [
    {
        data: 'name',
        title: 'Nombre',
    },
    {
        data: 'lastname',
        title: 'Apellido',
    },
    {
        data: 'age',
        title: 'Edad',
    },
    {
        data: 'gender',
        title: 'Género',
    },
    {
        data: 'course',
        title: 'Asignatura',
    },
];
export default {
    props: ['profesor'],
    data() {
        return {
            name: '',
            lastname: '',
            age: '',
            gender: '',
            course: '',
            tabulator: null,

        }
    },
    computed: {

    },
    watch: {

    },
    mounted() {
        this.listProfesores()

    },
    created() {

    },
    updated() {

    },
    methods: {
        submit(e) {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let midata = new FormData();
            midata.append('name', this.name);
            midata.append('lastname', this.lastname);
            midata.append('age', this.age);
            midata.append('gender', this.gender);
            midata.append('course', selectedCourse.value.name);
            const res = axios.post('/profesores', midata, config).then(function (response) {
                if (response.data.ejecuccion == true) {
                    // console.log(response.data);
                    estado.value = response.data.ejecuccion;
                    Swal.fire('¡Guardado correctamente!', '', 'success');
                    resetForm()
                } else {
                    Swal.fire('¡Lo sentimos, no se pudo guardar!', '', 'error')
                }
                if (estado.value == true) {
                    data.value.push({
                        name: response.data[0].name,
                        lastname: response.data[0].lastname,
                        age: response.data[0].age,
                        gender: response.data[0].gender,
                        course: response.data[0].course,
                    });
                } else {
                    Swal.fire('¡Lo sentimos, no se pudo guardar!', '', 'error')
                }

            }).catch(function (err) {
                console.log(err)
                if (err.response) {
                    mostrarerrores.value = 1;
                    if (err.response.data.errors.name) {
                        errors.value = jsonerrors.value = ({
                            name: err.response.data.errors.name[0],
                        })
                    }
                    else if (err.response.data.errors.lastname) {
                        errors.value = jsonerrors.value = ({
                            lastname: err.response.data.errors.lastname[0],
                        })
                    }
                    else if (err.response.data.errors.age) {
                        errors.value = jsonerrors.value = ({
                            age: err.response.data.errors.age[0],
                        })
                    }
                    else if (err.response.data.errors.gender) {
                        errors.value = jsonerrors.value = ({
                            gender: err.response.data.errors.gender[0],
                        })
                    }else {
                        errors.value = jsonerrors.value = ({
                            course: err.response.data.errors.course[0],
                        })
                    }
                }
            });
            let resetForm = () => {
                this.name = '';
                this.lastname = '';
                this.age = '';
                this.gender = '';
                this.course = '';
            }
        },
        listProfesores() {

            axios.get('/profesoresapi').then(function (response) {
                misestu.value = response.data[0];
                tableData.value = response.data[0];

                for (let i = 0; i < tableData.value.length; i++) {
                    data.value.push({
                        name: response.data[0][i].name,
                        lastname: response.data[0][i].lastname,
                        age: response.data[0][i].age,
                        gender: response.data[0][i].gender,
                        course: response.data[0][i].course,
                    });
                }
            });


        },
    }
}

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="mx-auto m-10 max-w-7xl">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Profesores</h3>
                        <p class="mt-1 text-sm text-gray-600">Crea profesores con todos sus datos.</p>
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
                                                <input type="text" v-model="name" id="name"
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
                                                <input type="text" v-model="lastname" id="lastname"
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
                                                <input type="text" v-model="age" id="age"
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
                                                <input type="text" v-model="gender" id="gender"
                                                    class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                    placeholder="" />
                                            </div>
                                            <div v-if="mostrarerrores == 1" class="col-span-3 sm:col-span-2">
                                                {{ errors.gender }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6">
                                        <div class="col-span-3 sm:col-span-2">
                                            <label for="gender"
                                                class="block text-sm font-medium text-gray-700">Asignatura</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <Listbox v-model="selectedCourse">
                                                    <div class="relative w-full">
                                                        <ListboxButton
                                                            class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 relative w-full rounded-lg bg-white py-2 pl-3 pr-10 text-left shadow-sm  sm:text-sm">
                                                            <span class="block truncate">{{ selectedCourse.name
                                                            }}</span>
                                                            <span
                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                                <ChevronUpDownIcon class="h-5 w-5 text-gray-400"
                                                                    aria-hidden="true" />
                                                            </span>
                                                        </ListboxButton>

                                                        <transition leave-active-class="transition duration-100 ease-in"
                                                            leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                            <ListboxOptions
                                                                class="submenuheadless absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                                <ListboxOption v-slot="{ active, selected }"
                                                                    v-for="cou in courses" :key="cou.name" :value="cou"
                                                                    as="template">
                                                                    <li :class="[
                                                                        active ? 'bg-emerald-100 text-amber-900' : 'text-gray-900',
                                                                        'relative cursor-pointer select-none py-2 pl-10 pr-4',
                                                                    ]">
                                                                        <span :class="[
                                                                            selected ? 'font-medium' : 'font-normal',
                                                                            'block truncate',
                                                                        ]">{{ cou.name }}</span>
                                                                        <span v-if="selected"
                                                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600">
                                                                            <CheckIcon class="h-5 w-5"
                                                                                aria-hidden="true" />
                                                                        </span>
                                                                    </li>
                                                                </ListboxOption>
                                                            </ListboxOptions>
                                                        </transition>
                                                    </div>
                                                </Listbox>
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
                    <DataTable ref="table" :data="data" :columns="columns" :options="{ select: true }" id="example"
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                    Nombre
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Apellidos
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Edad
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Género
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Asignatura
                                </th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>

            </div>
            <div id="example-table" ref="table"
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"></div>

        </div>
    </AppLayout>
</template>