import TableList from "@/components/table";

export default function RolesAndAccessControl() {
    const header = [
        { name: 'Department', align: 'left' },
        { name: 'Accessible Modules', align: 'left' },
        { name: 'Permitted Actions', align: 'left' },
        { name: 'Restrictions', align: 'left' },
    ];

    return (
        <>
            <h4>Roles And Access Control</h4>

            <TableList header={header} hasPage={false}>
                <tr>
                    <td>Administrator</td>
                    <td>All</td>
                    <td>All</td>
                    <td>None</td>
                </tr>
                <tr>
                    <td>Consultation</td>
                    <td>
                        <ul className="fs-4">
                            <li>Consultation</li>
                            <li>Patients</li>
                            <li>Admissions</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Update/View Consultation Data</li>
                            <li>Add Laboratory Requests</li>
                            <li>Add Radiology Requests</li>
                            <li>Add/Edit/View/Delete Patients</li>
                            <li>Admissions (Doctor Rounds and Order Sheet)</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Billing</td>
                    <td>
                        <ul className="fs-4">
                            <li>Billing</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Update/View/Print Billing Data</li>
                            <li>Add/Edit/View/Delete Laboratory Billing</li>
                            <li>Add/Edit/View/Delete Radiology Billing</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Cashier</td>
                    <td>
                        <ul className="fs-4">
                            <li>Cashier</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Update/View/Print Transactions</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Front Desk</td>
                    <td>
                        <ul className="fs-4">
                            <li>Front Desk</li>
                            <li>Patient</li>
                            <li>System (Call Out)</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Queue Patients</li>
                            <li>Add/Edit/View/Delete Patients</li>
                            <li>Access Call Out from System</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Laboratory</td>
                    <td>
                        <ul className="fs-4">
                            <li>Laboratory</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Edit/View/Print Laboratory Details</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Radiology</td>
                    <td>
                        <ul className="fs-4">
                            <li>Radiology</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Edit/View/Print Radiology Details</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Pharmacy</td>
                    <td>
                        <ul className="fs-4">
                            <li>Pharmacy</li>
                            <li>Inventory</li>
                            <li>Users (self)</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Edit/View/Print Pharmacy Details</li>
                            <li>Add Item in Pharmacy Details</li>
                            <li>Print Pick List</li>
                            <li>Update Own User Details</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Finance</td>
                    <td>
                        <ul className="fs-4">
                            <li>Dashboard</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Can view and print reports</li>
                        </ul>
                    </td>
                    <td>
                        Modules Not Mentioned in <br/>Accessible Modules
                    </td>
                </tr>
                <tr>
                    <td>Information Technology</td>
                    <td>
                        All
                    </td>
                    <td>
                        All
                    </td>
                    <td>
                        None
                    </td>
                </tr>
            </TableList>
        </>
    );
}