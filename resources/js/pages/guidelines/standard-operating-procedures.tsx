import TableList from "@/components/table";

export default function StandardOperatingProcedures() {
    const header = [
        { name: 'Module / Department', align: 'left' },
        { name: 'Position', align: 'left' },
        { name: 'Key Inputs', align: 'left' },
        { name: 'Core System Actions', align: 'left' },
        { name: 'Expected Output', align: 'left' },
    ];

    return (
        <>
            <h4>Standard Operating Procedures</h4>

            <TableList header={header} hasPage={false}>
                <tr>
                    <td>Administrator</td>
                    <td>
                        <ul className="fs-4">
                            <li>Head Of Admin</li>
                            <li>Admin Aide</li>
                        </ul>
                    </td>
                    <td>All Module Related</td>
                    <td>All Module Related</td>
                    <td>All Module Related</td>
                </tr>
                <tr>
                    <td>Consultation</td>
                    <td>
                        <ul className="fs-4">
                            <li>General Practitioner</li>
                            <li>Nurse</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Consultation Details</li>
                            <li>Subjective/Objective, <br />Assessment, Plan</li>
                            <li>Diagnosis, ICD10 Code</li>
                            <li>Prescriptions</li>
                            <li>Laboratory Requests</li>
                            <li>Radiology Requests</li>
                            <li>Vital Signs</li>
                            <li>Documents</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Logs Clinical Notes and Prescriptions</li>
                            <li>Able to Request Laboratory or Radiology</li>
                            <li>Able to Add Documents</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>History Data</li>
                            <li>Printable Prescriptions</li>
                            <li>Data ready to be moved to billing</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Billing</td>
                    <td>
                        <ul className="fs-4">
                            <li>Admin Aide</li>
                            <li>Staff</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Billing Details</li>
                            <li>Supplies</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Update Billing Details</li>
                            <li>Encode Supplies</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Printable Billing Details</li>
                            <li>Data ready to be moved to cashier</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Cashier</td>
                    <td>
                        <ul className="fs-4">
                            <li>Pharmacist</li>
                            <li>Pharmacy Assistant</li>
                            <li>Staff</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Cashier Details</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Process Payment</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Printable receipt</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Front Desk</td>
                    <td>
                        <ul className="fs-4">
                            <li>Admin Aide</li>
                            <li>Laboratory Aide</li>
                            <li>Radiology Aide</li>
                            <li>Staff</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Patient Visits</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Can queue patients</li>
                            <li>Update patient list</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Data will be moved to billing for lab or radio</li>
                            <li>Data will be moved to consultation</li>
                            <li>Updated patient data and patient lists</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Laboratory</td>
                    <td>
                        <ul className="fs-4">
                            <li>Head of Laboratory</li>
                            <li>Medical Technologist Supervisor</li>
                            <li>Medical Technologist</li>
                            <li>Laboratory Aide</li>
                            <li>Staff Aide</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Laboratory Tests</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Encodes Laboratory Test Results</li>
                            <li>Print Laboratory Test Results</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Updated Laboratory Test Data</li>
                            <li>Printable Laboratory Test Results</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Radiology</td>
                    <td>
                        <ul className="fs-4">
                            <li>Radiologist</li>
                            <li>Radiology Aide</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Radiology Tests</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Encodes Radiology Test Results</li>
                            <li>Print Radiology Test Results</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Updated Radiology Test Data</li>
                            <li>Printable Radiology Test Results</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Pharmacy</td>
                    <td>
                        <ul className="fs-4">
                            <li>Pharmacist</li>
                            <li>Pharmacy Assistant</li>
                            <li>Staff</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Inventory List</li>
                            <li>Pharmacy Details</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Add/Edit/Delete Inventory Item and its Stock Movement</li>
                            <li>Process Prescription Details</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Updated Inventory List</li>
                            <li>Updated Prescription Details</li>
                            <li>Printable Pick List</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Finance</td>
                    <td>
                        <ul className="fs-4">
                            <li>Head of Finance</li>
                            <li>Finance Officer</li>
                            <li>Accountant</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Dashboard Preview</li>
                            <li>Reports</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Print Reports</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Printed Reports, can be with graphs or just plain table</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Information Technology</td>
                    <td>
                        <ul className="fs-4">
                            <li>Software Engineer</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Development</li>
                            <li>Support</li>
                            <li>Testing</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Maintain and Update the software</li>
                            <li>Testing the software</li>
                            <li>Bug/Error fixes</li>
                            <li>Investigate problems with system</li>
                            <li>Setup web server and client workstations</li>
                            <li>Suggest Improvements</li>
                        </ul>
                    </td>
                    <td>
                        <ul className="fs-4">
                            <li>Well made and robust software</li>
                            <li>Smooth infirmary flow</li>
                        </ul>
                    </td>
                </tr>
            </TableList>
        </>
    );
}