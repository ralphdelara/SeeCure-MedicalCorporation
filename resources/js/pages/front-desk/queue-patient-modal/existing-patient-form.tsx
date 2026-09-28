import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import type { QueuePatientFormProps } from './types';
import { useEffect, useState } from 'react';
import { fetchUrl } from '@/lib/utils';
import { getSmallPatientList } from '@/actions/App/Http/Controllers/PatientController';
import TableSelect from '@/components/table-select';
import TableList from '@/components/table';
import { Item } from '@radix-ui/react-dropdown-menu';
import { IconCalendarDot, IconGenderAgender, IconMail, IconPhone } from '@tabler/icons-react';
import { PatientTableList } from '@/components/patient/list';
import personDefault from '@/assets/images/profile/person-default.png';

const ExistingPatientForm = ({ data, setData, errors = {} }: QueuePatientFormProps) => {
    const [keyword, setKeyword] = useState('');
    const [patientList, setPatientList] = useState<PatientTableList[]>([]);

    const searchPatient = async () => {
        const response = await fetchUrl(getSmallPatientList().url, 'GET', {
            keyword: keyword,
        });
        setPatientList(response);
    };

    const selectPatient = (id: string) => {
        setData('patient_id', data.patient_id === id ? '' : id);
    };

    useEffect(() => {
        searchPatient();
    }, []);

    return (
        <section role="tabpanel" className="body current">
            <div className="form-group">
                <label className="form-label" htmlFor="search-patient">
                    Search Patient *
                </label>
                <InputError message={errors.patient_id} className="mt-2" />
                <Input
                    id="patient-search"
                    placeholder="ex. Dela Cruz"
                    value={keyword}
                    onChange={(e) => setKeyword(e.target.value)}
                    onKeyDown={(e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault(); // Prevents the PARENT form from submitting
                            searchPatient(); // Calls your fetch logic directly
                        }
                    }}
                    className="mb-2"
                />
                <TableList
                    header={[
                        { name: 'Patient', align: 'left' },
                        { name: 'Date Of Birth', align: 'left' },
                        { name: 'Contact', align: 'left' },
                        {
                            name: 'Address',
                            align: 'left',
                        },
                    ]}
                    floatScrollbar={false}
                >
                    {patientList.map((item, index) => (
                        <tr
                            key={'existing-patient-' + item.id}
                            onClick={() => selectPatient(item.id)}
                            className={
                                'cursor-pointer' +
                                (item.id === data.patient_id ? ' border-success border-2' : '')
                            }
                        >
                            <td>
                                <div className="d-block">
                                    <div className="d-flex align-items-center">
                                        <div style={{ width: '40px' }}>
                                            <img
                                                className="rounded-circle"
                                                width="40"
                                                height="40"
                                                src={personDefault}
                                            />
                                        </div>
                                        <div className="ms-3">
                                            <h6 className="fs-4 fw-semibold mb-0">
                                                {item.full_name}
                                            </h6>
                                            <span className="fw-normal">
                                                {item.gender ? item.gender.name : 'N/A'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div className="d-flex align-items-start">
                                    <div>
                                        <h6>
                                            <IconCalendarDot size={20} />
                                        </h6>
                                        <span className="fw-normal">
                                            <IconGenderAgender size={20} />
                                        </span>
                                    </div>
                                    <div className="ms-3">
                                        <h6 className="fs-4 fw-normal">
                                            {item.date_of_birth ?? 'N/A'}
                                        </h6>
                                        <h6 className="fs-4 fw-normal">
                                            {item.age_computed ?? item.age ?? 'N/A'}
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div className="d-flex align-items-start">
                                    <div>
                                        <h6>
                                            <IconPhone size={20} />
                                        </h6>
                                        <h6>
                                            <IconPhone size={20} />
                                        </h6>
                                        <span className="fw-normal">
                                            <IconMail size={20} />
                                        </span>
                                    </div>
                                    <div className="ms-3">
                                        <h6 className="fs-4 fw-normal">
                                            {item.contact_number1 ?? 'N/A'}
                                        </h6>
                                        <h6 className="fs-4 fw-normal">
                                            {item.contact_number2 ?? 'N/A'}
                                        </h6>
                                        <h6 className="fs-4 fw-normal">{item.email ?? 'N/A'}</h6>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span className="fw-normal">{item.full_address}</span>
                            </td>
                        </tr>
                    ))}
                    {patientList.length === 0 && (
                        <tr>
                            <td colSpan={4} className="text-center">
                                <h4 className="text-danger">No records</h4>
                            </td>
                        </tr>
                    )}
                </TableList>
            </div>
        </section>
    );
};

export default ExistingPatientForm;
