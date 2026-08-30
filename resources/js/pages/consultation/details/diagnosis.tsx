import { getIcd10Codes } from '@/actions/App/Http/Controllers/Icd10CodeController';
import TableSelect from '@/components/table-select';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { fetchUrl, formSubmitResponse } from '@/lib/utils';
import { Head, useForm, usePage } from '@inertiajs/react';
import { Editor } from '@tinymce/tinymce-react';
import { useEffect, useState } from 'react';
import 'tinymce/tinymce';
import { updateDiagnosis } from '@/actions/App/Http/Controllers/ConsultationController';
import toast, { Toaster } from 'react-hot-toast';
import SaveButton from './save-button';

interface InertiaProps {
    consultationDetails: {
        id: string;
        diagnosis: {
            id: string;
            diagnosis: string;
            icd10_codes: {
                icd10_code_id: string;
                icd10_code: {
                    code: string;
                    description: string;
                };
            }[];
        };
    };
}

interface DiagnosisDetailsProps {
    id: string;
    icd10Ids: string[];
    diagnosis: string;
}

const Diagnosis = ({ showTab }: { showTab: boolean }) => {
    const { consultationDetails } = usePage().props as unknown as InertiaProps;
    const { diagnosis } = consultationDetails;
    const [keyword, setKeyword] = useState('');
    const [icd10CodeList, setIcd10CodeList] = useState<{ id: string }[]>([]);

    const getIcd10Ids = () => {
        const selectedIcd10Ids: string[] = [];
        const selectedIcd10Text: string[] = [];

        diagnosis.icd10_codes.forEach((item) => {
            selectedIcd10Ids.push(item.icd10_code_id);
            selectedIcd10Text.push(item.icd10_code.code + ' ' + item.icd10_code.description);
        });

        return {
            icd10Ids: selectedIcd10Ids,
            text: selectedIcd10Text,
        };
    };

    const [selectedText, setSelectedText] = useState<string[]>([...getIcd10Ids().text]);

    const { data, setData, patch, isDirty } = useForm<DiagnosisDetailsProps>({
        id: diagnosis.id,
        diagnosis: diagnosis.diagnosis,
        icd10Ids: getIcd10Ids().icd10Ids,
    });
    const showUnsavedWarning = isDirty;

    const searchIcd10 = async () => {
        const response = await fetchUrl(getIcd10Codes().url, 'GET', {
            keyword: keyword,
        });

        setIcd10CodeList(response);
    };

    useEffect(() => {
        searchIcd10();
    }, []);

    const updateSelected = (id: string) => {
        // adding ... creates shallow copies to avoid direct state mutation
        const selectedIdsTemp: string[] = [...data.icd10Ids];
        const selectedTextTemp: string[] = [...selectedText];
        const text: string | undefined = document
            .getElementById('row-' + id)
            ?.innerHTML.replace(/<\/?[^>]+(>|$)/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();

        const selectIdIndex: number = selectedIdsTemp.indexOf(id);
        const selectTextIndex: number = selectedTextTemp.indexOf(text ?? '');

        if (selectIdIndex !== -1) {
            selectedIdsTemp.splice(selectIdIndex, 1);
        } else {
            selectedIdsTemp.push(id);
        }

        if (selectTextIndex !== -1) {
            selectedTextTemp.splice(selectTextIndex, 1);
        } else {
            selectedTextTemp.push(text ?? '');
        }

        setData('icd10Ids', selectedIdsTemp);
        setSelectedText(selectedTextTemp);
    };

    const submitDiagnosis = (e: React.SubmitEvent<HTMLFormElement>) => {
        e.preventDefault();

        patch(updateDiagnosis().url, formSubmitResponse('Diagnosis'));
    };

    return (
        <>
            <Toaster position="top-center" reverseOrder={false} />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <div className="row w-100">
                        <div className="col-lg-12">
                            <div className="card border shadow-sm">
                                <div className="card-body">
                                    <form onSubmit={submitDiagnosis}>
                                        <SaveButton type="Diagnosis" isDirty={isDirty}/>
                                        <div className="form-group">
                                            <Label htmlFor="diagnosis">
                                                <h4 className="fw-bolder">Diagnosis</h4>
                                            </Label>
                                            <Editor
                                                value={data.diagnosis}
                                                onEditorChange={(newText) =>
                                                    setData('diagnosis', newText)
                                                }

                                                // Required for open-source self-hosting
                                                licenseKey="gpl"

                                                init={{
                                                    height: 400,
                                                    menubar: false,

                                                    // Point to the local static assets in your public folder
                                                    base_url: '/tinymce',
                                                    suffix: '.min',

                                                    // Configure local plugins and toolbars
                                                    plugins:
                                                        'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                                                    toolbar:
                                                        'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                                                }}
                                            />
                                        </div>
                                        <div className="form-group mt-3">
                                            <Label htmlFor="icd10code-search">
                                                <h5 className="fw-bolder">
                                                    ICD-10 Code{' '}
                                                    <small>
                                                        (optional but required for PhilHealth
                                                        Claims)
                                                    </small>
                                                </h5>
                                            </Label>
                                            <h6>Selected:</h6>
                                            {selectedText.map((item, index) => (
                                                <p key={'icd10-selected-' + index} className="mb-0">
                                                    {item}
                                                </p>
                                            ))}
                                            <Input
                                                id="icd10code-search"
                                                placeholder="Search ICD Code or Description"
                                                value={keyword}
                                                onChange={(e) => setKeyword(e.target.value)}
                                                onKeyDown={(e) => {
                                                    if (e.key === 'Enter') {
                                                        e.preventDefault(); // Prevents the PARENT form from submitting
                                                        searchIcd10(); // Calls your fetch logic directly
                                                    }
                                                }}
                                            />
                                            <TableSelect
                                                header={[
                                                    { name: 'Code', width: '10%', align: 'left' },
                                                    {
                                                        name: 'Description',
                                                        width: '90%',
                                                        align: 'left',
                                                    },
                                                ]}
                                            >
                                                {icd10CodeList.map((item, index) => (
                                                    <tr
                                                        key={'tr-' + item.id}
                                                        id={'row-' + item.id}
                                                        onClick={() => updateSelected(item.id)}
                                                        className={
                                                            data.icd10Ids.includes(item.id)
                                                                ? 'border-start border-success border-3'
                                                                : ''
                                                        }
                                                    >
                                                        {Object.entries(item).map(
                                                            ([key, value]) => {
                                                                if (key !== 'id') {
                                                                    return (
                                                                        <td
                                                                            key={
                                                                                'td-' +
                                                                                key +
                                                                                '-' +
                                                                                index
                                                                            }
                                                                        >
                                                                            {value}
                                                                        </td>
                                                                    );
                                                                }
                                                            },
                                                        )}
                                                    </tr>
                                                ))}
                                            </TableSelect>
                                        </div>
                                        <SaveButton type="Diagnosis" isDirty={isDirty}/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Diagnosis;
