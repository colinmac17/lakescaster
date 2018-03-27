import React, { Component, Fragment } from 'react';
import SpotTabs from './SpotTabs';
import Provider, {MyContext} from '../Provider';
import ReactDOM from 'react-dom';

export default class Spot extends Component{
    constructor(props){
        super(props)
        this.state = {
            apiPath: window.location.origin + '/api/' + this.props.path,
            path: this.props.path,
            date: this.props.date,
            name: this.props.name
        }
    }

    render(){
      return (
          <Provider path={this.state.path} apiPath={this.state.apiPath} date={this.state.date} name={this.state.name}>
              <MyContext.Consumer>
                  {(context) => (
                    <div className="container">
                        <h2 className="text-left spot-heading"><span className="spot-name">{context.state.name}</span> Surf Report and Forecast</h2>
                        <SpotTabs state={context.state} path={context.state.path} todayData={context.state} forecastData={context.state.data}/>
                    </div>
                  )}
              </MyContext.Consumer>
          </Provider>
        )
    }
}

if (document.getElementById('spot')) {
    const element = document.getElementById('spot')
    const props = Object.assign({}, element.dataset)
    ReactDOM.render(<Spot {...props} />, document.getElementById('spot'))
}