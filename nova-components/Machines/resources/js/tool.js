import Tool from './components/Tool';
import ControlPlan from "./components/ControlPlan";
import ControlPlanConfigForm from "./components/ControlPlanConfigForm";
import ComponentConfig from "./components/ComponentConfig";
import ComponentConfigForm from "./components/ComponentConfigForm";
import ControlPlanForm from "./components/ControlPlanForm";
import ComponentForm from "./components/ComponentForm";
import ComponentRow from "./components/ComponentRow";

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import specific icons */
import { faFileImage, faFilePdf, faFileArrowUp } from '@fortawesome/free-solid-svg-icons'
import { faTimesCircle } from '@fortawesome/free-regular-svg-icons'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* add icons to the library */
library.add(faFileImage, faFilePdf, faTimesCircle, faFileArrowUp)

Nova.booting((Vue, router, store) => {
    /* add font awesome icon component */
    Vue.component('font-awesome-icon', FontAwesomeIcon)

    Vue.component('machines', Tool);
    Vue.component('control-plan', ControlPlan);
    Vue.component('config-control-plan', ControlPlanConfigForm);
    Vue.component('create-control-plan', ControlPlanForm);
    Vue.component('component-config', ComponentConfig);
    Vue.component('component-config-form', ComponentConfigForm);
    Vue.component('component-form', ComponentForm);
    Vue.component('component-row', ComponentRow);
})
