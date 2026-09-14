import { Modal } from 'react-bootstrap';
import { Button } from '@/components/ui/button';
import TableList from '@/components/table';
import { getNormalRange } from '@/lib/utils';
import { usePage } from '@inertiajs/react';
import { NormalRangeProps } from '@/pages/laboratory/details/details-test-fields';
import { Fragment } from 'react';

const LaboratoryResultsModal = ({
    resultsShow,
    setResultsShow,
    resultsData,
}: {
    resultsShow: boolean;
    setResultsShow: any;
    resultsData: {
        fields: {
            field: {
                name: string;
            } & NormalRangeProps;
            value: string;
            last_modified_by: {
                full_name: string;
            };
            updated_at: string;
        }[];
        test: {
            name: string;
        };
    }[];
}) => {
    const { patientDetails } = usePage().props as unknown as {
        patientDetails: {
            gender_id: number;
        };
    };

    const header = [
        { name: 'Test', align: 'left' },
        { name: 'Value', align: 'left' },
        { name: 'Last Modified By', align: 'left' },
    ];
    return (
        <>
            <Modal show={resultsShow} size="lg" onHide={() => setResultsShow(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Laboratory Results</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className="wizard clearfix px-4" role="application">
                        <div className="row">
                            <div className="col-md-12">
                                <TableList header={header}>
                                    {resultsData.map((item, index) => (
                                        <Fragment key={'testList-' + index}>
                                            {item.fields.length > 1 && (
                                                <Fragment>
                                                    {item.fields.map((field, fieldIndex) => (
                                                        <tr key={'testList-' + index + '-' + fieldIndex}>
                                                            <td>{field.field.name}</td>
                                                            <td>{field.value}</td>
                                                            <td>
                                                                <h6 className="fw-bolder">
                                                                    {
                                                                        field.last_modified_by
                                                                            .full_name
                                                                    }
                                                                </h6>
                                                                {field.updated_at}
                                                            </td>
                                                        </tr>
                                                    ))}
                                                </Fragment>
                                            )}
                                            {item.fields.length === 1 && (
                                                <tr>
                                                    <td>
                                                        <h5 className="fw-bolder">
                                                            {item.test.name}
                                                        </h5>
                                                        {getNormalRange(
                                                            item.fields[0].field,
                                                            patientDetails.gender_id,
                                                        )}
                                                    </td>
                                                    <td width="50%">
                                                        <h5>{item.fields[0].value}</h5>
                                                    </td>
                                                    <td>
                                                        <h6 className="fw-bolder">
                                                            {
                                                                item.fields[0].last_modified_by
                                                                    .full_name
                                                            }
                                                        </h6>
                                                        {item.fields[0].updated_at}
                                                    </td>
                                                </tr>
                                            )}
                                        </Fragment>
                                    ))}
                                </TableList>
                            </div>
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="light" type="button" onClick={() => setResultsShow(false)}>
                        Close
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default LaboratoryResultsModal;
