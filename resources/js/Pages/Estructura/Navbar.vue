<template>
    <div>
        <Popover class="relative bg-white">
            <div class="mx-auto px-4 sm:px-6">
                <div
                    class="flex items-center justify-between border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                    <div class="flex justify-start lg:w-0 lg:flex-1">
                        <a href="#">
                            <span class="sr-only">Mi Institución</span>
                            <img class="h-8 w-auto sm:h-10" src="/avatar.png" alt="" />
                        </a>
                    </div>
                    <div class="-my-2 -mr-2 md:hidden">
                        <PopoverButton
                            class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Open menu</span>
                            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                    <PopoverGroup as="nav" class="hidden space-x-10 md:flex">
                        <Popover class="relative" v-slot="{ open }">
                            <PopoverButton v-for="opcion in opciones" :key="opcion.id" class=""
                                @click="abrir(opcion.id)"
                                :class="[open ? 'text-gray-900' : 'text-gray-500', 'mr-5 group inline-flex items-center rounded-md bg-white text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2']">
                                <span>{{ opcion.name }}</span>
                                <!--<ChevronDownIcon
                                    :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 mr-5 group-hover:text-gray-500']"
                                    aria-hidden="true" />-->
                            </PopoverButton>

                            <transition enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 translate-y-1" enter-to-class="opacity-100 translate-y-0"
                                leave-active-class="transition ease-in duration-150"
                                leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-1">
                                <!--v-for="item in solutions" :key="item.name" :href="item.href"-->
                                <PopoverPanel
                                    class="absolute z-10 -ml-4 mt-3 w-screen max-w-md transform px-2 sm:px-0 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2">
                                    <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                        <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                            <a v-for="menu in menus" :key="menu.id" 
                                                :href="menu.href"
                                                class="-m-3 flex items-start rounded-lg p-3 hover:bg-gray-50">
                                                <!--<component :is="item.icon" class="h-6 w-6 flex-shrink-0 text-indigo-600"
                                                    aria-hidden="true" />-->
                                                <div class="ml-4">
                                                    <p class="text-base font-medium text-gray-900">{{ menu.name }}
                                                    </p>
                                                    <!--<p class="mt-1 text-sm text-gray-500">{{ item.description }}</p>-->
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </PopoverPanel>
                            </transition>
                        </Popover>

                    </PopoverGroup>
                    <div class="hidden items-center justify-end md:flex md:flex-1 lg:w-0">
                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover"
                                            :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                            {{ $page.props.user.name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Configuración
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Perfil
                                    </DropdownLink>
                                    <div class="border-t border-gray-100" />

                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Salir
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>

                    </div>
                </div>
            </div>

            <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100" leave-active-class="duration-200 ease-in"
                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <PopoverPanel focus
                    class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition md:hidden">
                    <div
                        class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="px-5 pt-5 pb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <img class="h-8 w-auto" src="/avatar.png" alt="Your Company" />
                                </div>
                                <div class="-mr-2">
                                    <PopoverButton
                                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                    </PopoverButton>
                                </div>
                            </div>
                            <div class="mt-6">
                                <nav class="grid gap-y-4">
                                    <!--<a v-for="item in solutions" :key="item.name" :href="item.href"
                                            class="-m-3 flex items-center rounded-md p-3 hover:bg-gray-50">
                                            <component :is="item.icon" class="h-6 w-6 flex-shrink-0 text-indigo-600"
                                                aria-hidden="true" />
                                            <span class="ml-3 text-base font-medium text-gray-900">{{ item.name
                                                }}</span>
                                        </a>-->
                                    <Menu as="div" v-for="opcion in opciones" :key="opcion.id"
                                        class="relative inline-block text-left">
                                        <div>
                                            <MenuButton @click="abrir(opcion.id)"
                                                class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                                                {{ opcion.name }}
                                                <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                                            </MenuButton>
                                        </div>
                                        <div v-show="mostrar == true">
                                            <transition class="relative" v-for="menu in menus" :key="menu.id"
                                                enter-active-class="transition ease-out duration-200"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-200"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                                <MenuItems
                                                    class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                                    <div class="py-1">
                                                        <MenuItem v-slot="{ active }">
                                                        <a :href="menu.href"
                                                            :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                                        {{ menu.name }}</a>
                                                        </MenuItem>
                                                    </div>
                                                </MenuItems>
                                            </transition>
                                        </div>
                                    </Menu>

                                </nav>
                            </div>
                        </div>
                        <div class="space-y-6 py-6 px-5">
                            <div>
                                <a href="#"
                                    class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Regístrate</a>
                                <p class="mt-6 text-center text-base font-medium text-gray-500">
                                    Ya tienes una cuenta?
                                    {{ ' ' }}
                                    <a href="#" class="text-indigo-600 hover:text-indigo-500">Ingresar</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
        </Popover>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import {
    ArrowPathIcon,
    Bars3Icon,
    BookmarkSquareIcon,
    CalendarIcon,
    ChartBarIcon,
    CursorArrowRaysIcon,
    LifebuoyIcon,
    PhoneIcon,
    PlayIcon,
    ShieldCheckIcon,
    Squares2X2Icon,
    XMarkIcon,
} from '@heroicons/vue/24/outline'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
defineProps({
    title: String,
});

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};

const opciones = [
    {
        id: 1,
        name: "Personas", icon: ChartBarIcon
    },
    {
        id: 2,
        name: "Sitios", icon: ChartBarIcon
    },
    {
        id: 3,
        name: "Grados", icon: ChartBarIcon
    },

]
const mostrar = ref();
const menus = ref([]);
const active = true;
const abrir = (valor) => {
    mostrar.value = true;
    if (valor == 1) {
        menus.value = [
            { name: "Profesores", href: '/profesores', icon: ChartBarIcon },
            { name: "Estudiantes", href: '/estudiantes', icon: ChartBarIcon },
        ]
    } else if (valor == 2) {
        menus.value = [
            { name: "Cafetería", href: '/cafeteria', icon: ChartBarIcon },
            { name: "Salones", href: '/salones', icon: ChartBarIcon },
        ]
    } else {
        menus.value = [
            { name: "Sexto", href: '/sexto', icon: ChartBarIcon },
            { name: "Septimo", href: '/septimo', icon: ChartBarIcon },
            { name: "Octavo", href: '/octavo', icon: ChartBarIcon },
            { name: "Noveno", href: '/noveno', icon: ChartBarIcon },
            { name: "Décimo", href: '/decimo', icon: ChartBarIcon },
            { name: "Once", href: '/once', icon: ChartBarIcon },
            { name: "Especialidades", href: '/especialidades', icon: ChartBarIcon },
        ]
    }
}

</script>

<style>
.focus\:ring-indigo-500:focus {
    --tw-ring-opacity: 0;
    --tw-ring-color: none;
}

#headlessui-popover-panel-5 {
    display: block !important;
}


/*
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
        <div class="flex">
            <div class="shrink-0 flex items-center">
                <Link :href="route('dashboard')">
                    <ApplicationMark class="block h-9 w-auto" />
                </Link>
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </NavLink>
                
            </div>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="ml-3 relative">
                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                {{ $page.props.user.current_team.name }}

                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <div class="w-60">
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <DropdownLink :href="route('teams.show', $page.props.user.current_team)">
                                    Team Settings
                                </DropdownLink>

                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                    Create New Team
                                </DropdownLink>

                                <div class="border-t border-gray-100" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <DropdownLink as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="team.id == $page.props.user.current_team_id"
                                                    class="mr-2 h-5 w-5 text-green-400"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </DropdownLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </template>
                </Dropdown>
            </div>

            <div class="ml-3 relative">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                        </button>

                        <span v-else class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                {{ $page.props.user.name }}

                                <svg
                                    class="ml-2 -mr-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Account
                        </div>

                        <DropdownLink :href="route('profile.show')">
                            Profile
                        </DropdownLink>

                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                            API Tokens
                        </DropdownLink>

                        <div class="border-t border-gray-100" />

                        <form @submit.prevent="logout">
                            <DropdownLink as="button">
                                Log Out
                            </DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </div>
        </div>

        <div class="-mr-2 flex items-center sm:hidden">
            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                <svg
                    class="h-6 w-6"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                    <path
                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>
    </div>
</div>

<div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
            Dashboard
        </ResponsiveNavLink>
    </div>

    <div class="pt-4 pb-1 border-t border-gray-200">
        <div class="flex items-center px-4">
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
            </div>

            <div>
                <div class="font-medium text-base text-gray-800">
                    {{ $page.props.user.name }}
                </div>
                <div class="font-medium text-sm text-gray-500">
                    {{ $page.props.user.email }}
                </div>
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                Profile
            </ResponsiveNavLink>

            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                API Tokens
            </ResponsiveNavLink>

            <form method="POST" @submit.prevent="logout">
                <ResponsiveNavLink as="button">
                    Log Out
                </ResponsiveNavLink>
            </form>

            <template v-if="$page.props.jetstream.hasTeamFeatures">
                <div class="border-t border-gray-200" />

                <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Team
                </div>

                <ResponsiveNavLink :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                    Team Settings
                </ResponsiveNavLink>

                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                    Create New Team
                </ResponsiveNavLink>

                <div class="border-t border-gray-200" />

                <div class="block px-4 py-2 text-xs text-gray-400">
                    Switch Teams
                </div>

                <template v-for="team in $page.props.user.all_teams" :key="team.id">
                    <form @submit.prevent="switchToTeam(team)">
                        <ResponsiveNavLink as="button">
                            <div class="flex items-center">
                                <svg
                                    v-if="team.id == $page.props.user.current_team_id"
                                    class="mr-2 h-5 w-5 text-green-400"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <div>{{ team.name }}</div>
                            </div>
                        </ResponsiveNavLink>
                    </form>
                </template>
            </template>
        </div>
    </div>
</div>
</nav>-->
*/
</style>

