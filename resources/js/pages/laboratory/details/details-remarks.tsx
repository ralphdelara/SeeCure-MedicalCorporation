import { Input } from '@/components/ui/input';

const DetailsRemarks = ({
    typeId,
    testId,
    fieldName,
    dataFields,
    setDataFields,
}: {
    typeId: string;
    testId: string;
    fieldName: string;
    dataFields: any;
    setDataFields: React.Dispatch<React.SetStateAction<{}>>;
}) => {
    const changeFieldValue = (fieldId: string, value: string) => {
        let fields: Record<string, any> = {
            ...dataFields,
        };
        fields[fieldId] = value;
        setDataFields(fields);
    };

    return (
        <>
            <div className="col-md-12">
                <h5 className="fw-semibold">Remarks</h5>
            </div>
            <Input
                id={'type_' + typeId + '_test_' + testId + '_remarks'}
                value={dataFields['type_' + typeId + '_test_' + testId + '_remarks'] ?? ''}
                onChange={(e) =>
                    changeFieldValue(
                        'type_' + typeId + '_test_' + testId + '_remarks',
                        e.target.value,
                    )
                }
                placeholder={fieldName + ' Remarks'}
                className="mb-3"
            />
        </>
    );
};

export default DetailsRemarks;
