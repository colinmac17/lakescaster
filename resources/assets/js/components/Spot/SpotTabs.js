import React, {Fragment} from 'react';
import Tabs from './Tabs';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Today from './Today';
import Forecast from './Forecast';
import Media from './Media';
import Reviews from './Reviews';
import {MyContext} from '../Provider';

const SpotTabs = () => {
 return (
     <MyContext.Consumer>
         {(context) => (
             <Fragment>
                 <Router>
                     <Fragment>
                         <Tabs path={context.state.path}/>
                         <Switch>
                             <Route exact path={`/${context.state.path}`} component={Today} />
                             <Route exact path={`/${context.state.path}/forecast`} component={Forecast} />
                             <Route exact path={`/${context.state.path}/media`} component={Media} />
                             <Route exact path={`/${context.state.path}/reviews`} component={Reviews} />
                         </Switch>
                     </Fragment>
                 </Router>
             </Fragment>
         )}
     </MyContext.Consumer>
 )
}

export default SpotTabs;

/*
//     * Add ability to add props to Routes
//     * Resource: https://github.com/ReactTraining/react-router/issues/4105
//  */
// const renderMergedProps = (component, ...rest) => {
//     const finalProps = Object.assign({}, ...rest);
//     return (
//         React.createElement(component, finalProps)
//     );
// }
//
// const PropsRoute = ({ component, ...rest }) => {
//     return (
//         <Route {...rest} render={routeProps => {
//             return renderMergedProps(component, routeProps, rest);
//         }}/>
//     );
// }
// /*
//     * End source
// */