import React from 'react';
import './App.css';
import Home from "./Pages/Home";

/**
 *
 */
interface Props {
    endpointUrl: string
}

/**
 *
 */
class App extends React.Component<Props> {

    /**
     *
     */
    render() {

        // TODO: Add routing logic here.
        // The app should be thought as the base.html.twig file that
        // controls the which content is displayed.
        // per default the Home page will be displayed.
        return (
            <Home endpointUrl={this.props.endpointUrl}></Home>
        )
    }
}

export default App;
