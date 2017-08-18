/**!
 * Copyright (c) 2014, Facebook, Inc.
 * All rights reserved.
 *
 * This source code is licensed under the BSD-style license found in the
 * LICENSE file in the root directory of this source tree. An additional grant
 * of patent rights can be found in the PATENTS file in the same directory.
 */
var Table = React.createClass({
  render: function () {
    var rows = this.props.data.map(function (row, index) {
      var cells = row.map(function(cell) {
        return <td key={cell}>{cell}</td>;
      });

      return <tr>{cells}</tr>;
    });

    return (
      <table>
        <tbody>{rows}</tbody>
      </table>
    );
  }
});
