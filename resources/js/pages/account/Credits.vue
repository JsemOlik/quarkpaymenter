<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/account/Layout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Credit settings',
        href: '/settings/credits',
    },
];

const credits = ref(25.00); // Dummy balance
const refillAmount = ref('');
const refilling = ref(false);
const refillSuccess = ref(false);

function refillCredits() {
    if (!refillAmount.value || isNaN(Number(refillAmount.value)) || Number(refillAmount.value) <= 0) return;
    refilling.value = true;
    setTimeout(() => {
        credits.value += Number(refillAmount.value);
        refillAmount.value = '';
        refillSuccess.value = true;
        refilling.value = false;
        setTimeout(() => (refillSuccess.value = false), 1500);
    }, 1000);
}

// Dummy history
const creditHistory = ref([
    { id: 1, type: 'Refill', amount: 20, date: '2024-06-27', status: 'Completed' },
    { id: 2, type: 'Usage', amount: -5, date: '2024-06-25', status: 'Hosting Payment' },
    { id: 3, type: 'Refill', amount: 10, date: '2024-06-20', status: 'Completed' },
]);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Credit settings" />
        <SettingsLayout>
            <div class="space-y-12">
                <h1 class="text-4xl font-extrabold text-white mb-8 tracking-tight">Credits</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="bg-gradient-to-br from-neutral-900 to-neutral-800 rounded-2xl p-8 border border-neutral-700 shadow-lg flex items-center gap-4">
                        <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-yellow-500/10">
                            <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3zm0 9c-4.418 0-8-1.79-8-4V7c0-2.21 3.582-4 8-4s8 1.79 8 4v6c0 2.21-3.582 4-8 4z"/></svg>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-white mb-1">Current Credits</div>
                            <div class="text-3xl font-extrabold text-white">${{ credits.toFixed(2) }}</div>
                        </div>
                    </div>
                    <div class="md:col-span-2 bg-neutral-900 rounded-2xl p-8 border border-neutral-700 shadow-lg flex flex-col justify-center">
                        <div class="text-xl font-bold text-white mb-2">Refill Credits</div>
                        <div class="text-sm text-neutral-400 mb-4">Add credits to your account to use for hosting services.</div>
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <input
                                v-model="refillAmount"
                                type="number"
                                min="1"
                                step="0.01"
                                placeholder="Enter amount"
                                class="flex-1 rounded-lg bg-neutral-800 border border-neutral-700 text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg transition-all"
                                :disabled="refilling"
                            />
                            <button
                                @click="refillCredits"
                                :disabled="refilling || !refillAmount || isNaN(Number(refillAmount)) || Number(refillAmount) <= 0"
                                class="px-8 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-lg transition-all focus:outline-none focus:ring-2 focus:ring-blue-400 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                <span v-if="!refilling && !refillSuccess">Add Credits</span>
                                <span v-if="refilling">Adding...</span>
                                <span v-if="refillSuccess">Added!</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="text-xl font-bold text-white mb-4">Credit History</div>
                    <div class="bg-neutral-900 rounded-xl border border-neutral-700 overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead>
                                <tr class="text-neutral-400 text-sm">
                                    <th class="py-3 px-6">Date</th>
                                    <th class="py-3 px-6">Type</th>
                                    <th class="py-3 px-6">Amount</th>
                                    <th class="py-3 px-6">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in creditHistory" :key="item.id" class="border-t border-neutral-800 text-white">
                                    <td class="py-3 px-6">{{ item.date }}</td>
                                    <td class="py-3 px-6">{{ item.type }}</td>
                                    <td class="py-3 px-6">
                                        <span :class="item.amount > 0 ? 'text-green-400' : 'text-red-400'">
                                            {{ item.amount > 0 ? '+' : '' }}${{ Math.abs(item.amount) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6">{{ item.status }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
