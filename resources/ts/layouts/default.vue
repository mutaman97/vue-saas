<script lang="ts" setup>
// import { useConfigStore } from '@core/stores/config'
import {AppContentLayoutNav} from '@layouts/enums'
import {switchToVerticalNavOnLtOverlayNavBreakpoint} from '@layouts/utils'

const DefaultLayoutWithHorizontalNav = defineAsyncComponent(() => import('./components/DefaultLayoutWithHorizontalNav.vue'))
const DefaultLayoutWithVerticalNav = defineAsyncComponent(() => import('./components/DefaultLayoutWithVerticalNav.vue'))
// const configStore = useConfigStore()

// ℹ️ This will switch to vertical nav when define breakpoint is reached when in horizontal nav layout

// Remove below composable usage if you are not using horizontal nav layout in your app
switchToVerticalNavOnLtOverlayNavBreakpoint()

const {layoutAttrs, injectSkinClasses} = useSkins()

injectSkinClasses()


import {useTheme} from 'vuetify'
// import BuyNow from '@core/components/BuyNow.vue'
import ScrollToTop from '@core/components/ScrollToTop.vue'
import initCore from '@core/initCore'
import {
    initConfigStore,
    useConfigStore,
} from '@core/stores/config'
import {hexToRgb} from '@layouts/utils'

const {global} = useTheme()

// ℹ️ Sync current theme with initial loader theme
initCore()
initConfigStore()

const configStore = useConfigStore()
</script>

<template>
    <VLocaleProvider :rtl="configStore.isAppRTL">
        <!-- ℹ️ This is required to set the background color of active nav link based on currently active global theme's primary -->
        <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
            <Suspense
                :timeout="0"
                @fallback="isFallbackStateActive = true"
                @resolve="isFallbackStateActive = false"
            >
                <Component
                    v-bind="layoutAttrs"
                    :is="configStore.appContentLayoutNav === AppContentLayoutNav.Vertical ? DefaultLayoutWithVerticalNav : DefaultLayoutWithHorizontalNav"
                >
                    <slot v-bind="layoutAttrs" :configStore="configStore" />
                </Component>
            </Suspense>

            <!--            <BuyNow/>-->
            <ScrollToTop/>
        </VApp>
    </VLocaleProvider>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";
</style>
