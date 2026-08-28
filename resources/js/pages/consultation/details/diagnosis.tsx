import { getIcd10Codes } from '@/actions/App/Http/Controllers/Icd10CodeController';
import TableSelect from '@/components/table-select';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { fetchUrl } from '@/lib/utils';
import { Head, useForm } from '@inertiajs/react';
import { Editor } from '@tinymce/tinymce-react';
import { useEffect, useState } from 'react';
import { Button } from '@/components/ui/button';
import 'tinymce/tinymce';
import { IconDeviceFloppy } from '@tabler/icons-react';

const Diagnosis = ({ showTab }: { showTab: boolean }) => {
    const [keyword, setKeyword] = useState('');
    const [icd10CodeList, setIcd10CodeList] = useState([]);
    const { data, setData, post } = useForm({
        diagnosis: '',
        ids: [],
        text: [],
    });

    const searchIcd10 = async () => {
        const response = await fetchUrl(getIcd10Codes().url, 'GET', {
            keyword: keyword,
        });

        setIcd10CodeList(response);
    };

    useEffect(() => {
        searchIcd10();
    }, [keyword]);

    const updateSelected = (id: number) => {
        const selectedIdsTemp = data.ids;
        const selectedTextTemp = data.text;
        const text = document
            .getElementById('row-' + id)
            ?.innerHTML.replace(/<\/?[^>]+(>|$)/g, ' ')
            .replace(/\s+/g, ' ')
            .trim();

        const selectIdIndex = selectedIdsTemp.indexOf(id);
        const selectTextIndex = selectedTextTemp.indexOf(text ?? '');

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

        setData('ids', selectedIdsTemp);

        setData('text', selectedTextTemp);
    };
    return (
        <>
            <Head title="Diagnosis" />
            <div className={'tab-content mt-3' + (!showTab ? ' hidden' : '')}>
                <div className="tab-pane fade show active" role="tabpanel" tabIndex={1}>
                    <div className="row w-100">
                        <div className="col-lg-12">
                            <div className="card border shadow-sm">
                                <div className="card-body">
                                    <form>
                                        <div className="mt-2 text-right">
                                            <Button size="lg">
                                                <i>
                                                    <IconDeviceFloppy className="me-1" />
                                                </i>
                                                Save Diagnosis
                                            </Button>
                                        </div>
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
                                            <Input
                                                id="icd10code-search"
                                                placeholder="Search ICD Code or Description"
                                                value={keyword}
                                                onChange={(e) => setKeyword(e.target.value)}
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
                                                            data.ids.includes(item.id)
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
                                        <div className="mt-2 text-right">
                                            <Button size="lg">
                                                <i>
                                                    <IconDeviceFloppy className="me-1" />
                                                </i>
                                                Save Diagnosis
                                            </Button>
                                        </div>
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
