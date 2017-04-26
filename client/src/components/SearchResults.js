import React, {Component} from 'react';
import {Table, ProgressBar} from 'react-bootstrap';
import SearchResult from './SearchResult';

export default class SearchResults extends Component {
    render() {
        if (this.props.searching) {
            return (
                <ProgressBar min={0} max={1} now={this.props.responses / this.props.domains}/>
            )
        } else {
            if (this.props.responses > 0 && this.props.results.length === 0) {
                return (
                    <Table>
                        <tbody>
                            <tr>
                                <td>
                                    <p>Nothing found!</p>
                                </td>
                            </tr>
                        </tbody>
                    </Table>
                );
            }
            return (
                <Table className="table-striped table-hover">
                    <tbody>
                        {this.props.results.map(result => <SearchResult key={result['hash']} result={result}/>)}
                    </tbody>
                </Table>
            );
        }
    }
}