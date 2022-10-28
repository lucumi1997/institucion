<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'


</script>

<style>
/*@import 'datatables.net-dt';*/
@import 'datatables.net-dt';
</style>
<script>

import { onMounted, ref } from 'vue';
import DataTable from 'datatables.net-vue3';
import Select from 'datatables.net-select';
import DataTableBs5 from 'datatables.net-bs5';
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
import Tabla from '../Tablas/Tabla.vue';
const genero = [
    { name: 'Masculino' },
    { name: 'Femenino' },
    { name: 'Otro' },
]
const selectedGender = ref(genero[0])
/**SELECT ***/


const table = ref();
const misestu = ref();
const data = ref([]);
const estado = ref();
const errors = ref();
const jsonerrors = ref();
const mostrarerrores = ref(0);
const open = ref(false);
DataTable.use(Select);
const columns = [
    {
        data: 'id',
        title: 'Id',
    },
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
        data: 'acciones',
        title: 'Acciones',
        campo: 'editar',
    },
];
export default {
    props: ["estudiante"],
    data() {
        return {
            name: "",
            lastname: "",
            age: "",
            gender: "",
            select: false
        };
    },
    computed: {},
    watch: {},
    mounted() {
    },
    created() {
    },
    updated() {
    },
    methods: {
        submit(e) {
            const config = {
                headers: {
                    "content-type": "multipart/form-data"
                }
            };
            let midata = new FormData();
            midata.append("name", this.name);
            midata.append("lastname", this.lastname);
            midata.append("age", this.age);
            midata.append("gender", selectedGender.value.name);
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
                    data.value.push({
                        name: response.data[0].name,
                        lastname: response.data[0].lastname,
                        age: response.data[0].age,
                        gender: response.data[0].gender,
                        acciones: columns[5].campo
                    });
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
        },

        update() {
            dt.rows({ selected: true }).every(function () {
                let idx = table.value.dt().context;
                console.log(idx);
            });
        },
        remove() {
            dt.rows({ selected: true }).every(function () {
                let idx = data.value.indexOf(this.data());
                data.value.splice(idx, 1);
            });
            console.log(dt);
        },
    },
    components: { Tabla }
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
                                                <Listbox v-model="selectedGender">
                                                    <div class="relative w-full">
                                                        <ListboxButton
                                                            class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 relative w-full rounded-lg bg-white py-2 pl-3 pr-10 text-left shadow-sm  sm:text-sm">
                                                            <span class="block truncate">{{ selectedGender.name
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
                                                                    v-for="gen in genero" :key="gen.name" :value="gen"
                                                                    as="template">
                                                                    <li :class="[
                                                                        active ? 'bg-emerald-100 text-amber-900' : 'text-gray-900',
                                                                        'relative cursor-pointer select-none py-2 pl-10 pr-4',
                                                                    ]">
                                                                        <span :class="[
                                                                            selected ? 'font-medium' : 'font-normal',
                                                                            'block truncate',
                                                                        ]">{{ gen.name }}</span>
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
                    </DataTable>
                </div>

            </div>
    
            <div class="mx-auto m-10 max-w-7xl">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg p-4">
                    <Tabla/>
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

                    <div class="fixed inset-0 z-10 overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div
                                                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                <ExclamationTriangleIcon class="h-6 w-6 text-red-600"
                                                    aria-hidden="true" />
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <DialogTitle as="h3"
                                                    class="text-lg font-medium leading-6 text-gray-900">Deactivate
                                                    account</DialogTitle>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500">Are you sure you want to deactivate
                                                        your account? All of your data will be permanently removed. This
                                                        action cannot be undone.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="open = false">Deactivate</button>
                                        <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                            @click="open = false" ref="cancelButtonRef">Cancel</button>
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