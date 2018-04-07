import React, { Component, Fragment } from 'react';
import SpotTabs from './SpotTabs';
import Provider, {MyContext} from '../Provider';
import ReactDOM from 'react-dom';

class Spot extends Component{
    constructor(props){
        super(props)
        this.state = {
            apiPath: window.location.origin + '/api/' + this.props.path,
            path: this.props.path,
            date: this.props.date,
            name: this.props.name,
            description: this.props.description,
            showDescription: true
        }

        this.toggleDescription = this.toggleDescription.bind(this);
    }

    toggleDescription(){
        this.setState({
            showDescription: !this.state.showDescription
        })
    }

    render(){
      return (
          <Provider path={this.state.path} description ={this.state.description} apiPath={this.state.apiPath} date={this.state.date} name={this.state.name}>
              <MyContext.Consumer>
                  {(context) => (
                    <div className="container">
                        <h2 className="text-left spot-heading"><span className="spot-name">{context.state.name}</span> Surf Report and Forecast</h2>
                        <p>{this.state.showDescription ? this.state.description : ''} {this.state.showDescription ? <span onClick={this.toggleDescription} className="text-primary description-toggle" role="button">hide description</span> : <span className="text-primary description-toggle" role="button" onClick={this.toggleDescription}>show description</span>} </p>
                        <SpotTabs />
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