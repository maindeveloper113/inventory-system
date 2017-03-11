package com.inventory.cis;

import android.app.Activity;
import android.app.Dialog;
import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.DialogInterface;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.BitmapDrawable;
import android.graphics.drawable.ColorDrawable;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.view.Window;
import android.view.inputmethod.InputMethodManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.ByteArrayOutputStream;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

import static android.R.attr.format;
import static com.inventory.cis.SessionManager.KEY_UserId;

/**
 * Created by Administrator on 12/20/2016.
 */

public class AddInventoryActivity extends Activity implements View.OnClickListener {

    ImageView image;
    EditText txtPartNumber, txtSerialNumber, txtLocation, txtQuantity,txtRemark, txtDescription;
    Button btnImage, btnPartNumber, btnSerialNumber, btnAdd;
    Typeface Set_font;
    Bitmap photo;
    String strPartNumber, strSerialNumber, strLocation, strRemark, strDescription;
    Integer intQuantity, user_id;

    String result;

    Spinner spinnerLocation,  spinnerDescription;
    List<String> listLocation, listDescription;

    ArrayAdapter<String> adpLocation, adpDescription;

    SessionManager session;

    private static final int CAMERA_REQUEST = 1888;
    private static final int PART_NUMBER_SCANN = 1;
    private static final int SERIAL_NUMBER_SCANN = 2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.add_inventory);
        init();
        SetFont();



        setSpinnerData();

    }

    private void setSpinnerLocation() {


        adpLocation = new ArrayAdapter<String>
                (this, android.R.layout.simple_dropdown_item_1line, listLocation);
        adpLocation.setDropDownViewResource(android.R.layout.simple_dropdown_item_1line);

        spinnerLocation.setAdapter(adpLocation);

        spinnerLocation.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {

            @Override
            public void onItemSelected(AdapterView<?> arg0, View arg1,
                                       int arg2, long arg3) {
                // TODO Auto-generated method stub

                txtLocation.setText(listLocation.get(arg2));
            }
            @Override
            public void onNothingSelected(AdapterView<?> arg0) {
                // TODO Auto-generated method stub

            }
        });




        if (listLocation.size() == 0)
            spinnerLocation.setVisibility(View.GONE);
        else
            spinnerLocation.setVisibility(View.VISIBLE);

    }

    private void setSpinnerDescription() {

        adpDescription = new ArrayAdapter<String>
                (this, android.R.layout.simple_dropdown_item_1line, listDescription);
        adpDescription.setDropDownViewResource(android.R.layout.simple_dropdown_item_1line);

        spinnerDescription.setAdapter(adpDescription);
        spinnerDescription.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {

            @Override
            public void onItemSelected(AdapterView<?> arg0, View arg1,
                                       int arg2, long arg3) {
                // TODO Auto-generated method stub

                txtDescription.setText(listDescription.get(arg2));
            }
            @Override
            public void onNothingSelected(AdapterView<?> arg0) {
                // TODO Auto-generated method stub

            }
        });


        if (listDescription.size() == 0)
            spinnerDescription.setVisibility(View.GONE);
        else
            spinnerDescription.setVisibility(View.VISIBLE);

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.activity_main, menu);
        return true;
    }

    private void init() {
        image = (ImageView) findViewById(R.id.image);
        txtPartNumber = (EditText)findViewById(R.id.txt_partnumber);
        txtSerialNumber = (EditText)findViewById(R.id.txt_serialnumber);
        txtLocation = (EditText)findViewById(R.id.txt_location);
        txtQuantity = (EditText)findViewById(R.id.txt_quantity);
        txtDescription = (EditText)findViewById(R.id.txt_description);
        txtRemark = (EditText)findViewById(R.id.txt_remark);

        intQuantity = 1;
        txtQuantity.setText(String.valueOf(intQuantity));

        btnImage = (Button)findViewById(R.id.btn_photo);
        btnPartNumber =(Button)findViewById(R.id.btn_partnumber);
        btnSerialNumber= (Button)findViewById(R.id.btn_serialnumber);
        btnAdd = (Button)findViewById(R.id.btn_add);

        spinnerLocation = (Spinner) findViewById(R.id.spinner_location);
        spinnerDescription = (Spinner) findViewById(R.id.spinner_description);

        btnImage.setOnClickListener(this);
        btnPartNumber.setOnClickListener(this);
        btnSerialNumber.setOnClickListener(this);
        btnAdd.setOnClickListener(this);


        listLocation = new ArrayList<String>();
        listDescription = new ArrayList<String>();

    }

    private void SetFont() {
        Set_font = Typeface.createFromAsset(
                getApplicationContext().getAssets(), "fonts/AGENCYR.TTF");

        btnAdd.setTypeface(Set_font);

        txtPartNumber.setTypeface(Set_font);
        txtSerialNumber.setTypeface(Set_font);
        txtLocation.setTypeface(Set_font);
        txtQuantity.setTypeface(Set_font);
        txtRemark.setTypeface(Set_font);
        txtDescription.setTypeface(Set_font);

    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.btn_add:

                InputMethodManager inputManager = (InputMethodManager) getSystemService(Context.INPUT_METHOD_SERVICE);

                inputManager.hideSoftInputFromWindow(getCurrentFocus()
                        .getWindowToken(), InputMethodManager.HIDE_NOT_ALWAYS);

                strRemark = txtRemark.getText().toString();
                strDescription = txtDescription.getText().toString();
                strLocation = txtLocation.getText().toString();
                String strQuantity  = txtQuantity.getText().toString();

                strPartNumber = txtPartNumber.getText().toString();
                strSerialNumber = txtSerialNumber.getText().toString();
                //photo = ((BitmapDrawable)image.getDrawable()).getBitmap();


                if (strDescription.length() <= 0 || strDescription.equals("")) {
                    txtDescription.setError("Invalid description");
                } else if (strQuantity.length() <= 0 || strQuantity.equals("")) {
                    txtQuantity.setError("Invalid quantity");
                } else if (strLocation.length() <= 0 || strLocation.equals("")) {
                    txtLocation.setError("Invalid location");
                } else {

                    intQuantity = Integer.parseInt(strQuantity);

                    if (StaticData.isNetworkConnected(getApplicationContext())) {
                        try {
                            new AddInventoryActivity.AddOperation().execute();
                        } catch (Exception e) {
                            //e.printStackTrace();
                        }
                    } else {
                        Toast.makeText(getApplicationContext(),
                                "Not connected to Internet", Toast.LENGTH_SHORT)
                                .show();
                    }
                }



                break;
            case R.id.btn_partnumber:
                try {
                    Intent intent = new Intent("com.google.zxing.client.android.SCAN");
                    startActivityForResult(intent, PART_NUMBER_SCANN);
                } catch (ActivityNotFoundException ex) {
                    ex.printStackTrace();

                    //if you haven't install barcodeScanner app, download it from Google Play
                    downloadScanBarcode();
                }


                break;
            case R.id.btn_serialnumber:
                try {
                    Intent intent = new Intent("com.google.zxing.client.android.SCAN");
                    startActivityForResult(intent, SERIAL_NUMBER_SCANN);
                } catch (ActivityNotFoundException ex) {
                    ex.printStackTrace();

                    //if you haven't install barcodeScanner app, download it from Google Play
                    downloadScanBarcode();
                }
                break;
            case R.id.btn_photo:
                Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
                startActivityForResult(cameraIntent, CAMERA_REQUEST);



                break;
        }
    }


    private void downloadScanBarcode() {
        Uri uri = Uri.parse("market://search?q=pname:" + "com.google.zxing.client.android");
        Intent intent = new Intent(Intent.ACTION_VIEW, uri);
        try {
            startActivity(intent);
        } catch (ActivityNotFoundException ex) {
            ex.printStackTrace();
        }
    }

    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == CAMERA_REQUEST && resultCode == Activity.RESULT_OK) {
            photo = (Bitmap) data.getExtras().get("data");
            image.setImageBitmap(photo);
        }
        else if (requestCode == PART_NUMBER_SCANN) {
            if (resultCode == RESULT_OK) {
                //format.setText(data.getStringExtra("SCAN_RESULT_FORMAT"));
                txtPartNumber.setText(data.getStringExtra("SCAN_RESULT"));
            } else if (resultCode == RESULT_CANCELED) {
                //format.setText("Press a button to start a scan.");
                txtPartNumber.setText("Scan cancelled.");
            }
        }
        else if (requestCode == SERIAL_NUMBER_SCANN) {
            if (resultCode == RESULT_OK) {
                //format.setText(data.getStringExtra("SCAN_RESULT_FORMAT"));
                txtSerialNumber.setText(data.getStringExtra("SCAN_RESULT"));
            } else if (resultCode == RESULT_CANCELED) {
                //format.setText("Press a button to start a scan.");
                txtSerialNumber.setText("Scan cancelled.");
            }
        }
    }

    private class AddOperation extends AsyncTask<String, Void, Void> {

        Dialog pDialog = new Dialog(AddInventoryActivity.this);

        protected void onPreExecute() {
            // Dialog.setMessage("Authanticating...");
            pDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            pDialog.getWindow().setBackgroundDrawable(
                    new ColorDrawable(Color.TRANSPARENT));
            pDialog.setContentView(R.layout.custom_image_dialog);
            pDialog.show();
            pDialog.setCancelable(false);
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {

            try {

                postData();
                JSONObject error = new JSONObject(result);
                Boolean strError = error.getBoolean("error");
                if (!strError) {
                    //Toast.makeText(getApplicationContext(), "Success registe new inventory", Toast.LENGTH_SHORT).show();
                    Intent i = new Intent(AddInventoryActivity.this, homeActivity.class);
                    startActivity(i);
                }
                else
                    Toast.makeText(getApplicationContext(), "Failed registe new inventory", Toast.LENGTH_SHORT).show();

            } catch (JSONException e) {
                // TODO Auto-generated catch block
                //e.printStackTrace();
            } catch (NullPointerException n) {
                n.printStackTrace();
            }

            return null;
        }

        protected void onPostExecute(Void unused) {

            try {
                if (pDialog.isShowing())
                    pDialog.dismiss();

            } catch (Exception e) {
                // TODO: handle exception
                //e.printStackTrace();
            }

        }
    }

    public void postData() throws NullPointerException {
        // TODO Auto-generated method stub

        try {
            Log.d("data", "sent");
            JSONObject json = new JSONObject();

            HashMap<String, String> userDetail;
            session = new SessionManager(getApplicationContext());
            userDetail = session.getUserDetails();
            user_id = Integer.parseInt(userDetail.get(KEY_UserId));

            String encodedImage = "";
            if (photo != null) {
                ByteArrayOutputStream baos = new ByteArrayOutputStream();
                photo.compress(Bitmap.CompressFormat.JPEG, 100, baos);
                byte[] imageBytes = baos.toByteArray();
                encodedImage = Base64.encodeToString(imageBytes, Base64.DEFAULT);
            }

            json.put("user_id", user_id);
            json.put("photo", encodedImage);
            json.put("part_number", strPartNumber);
            json.put("serial_number", strSerialNumber);
            json.put("location", strLocation);
            json.put("quantity", intQuantity);
            json.put("remark", strRemark);
            json.put("description", strDescription);



            String url = StaticData.getlink(getApplicationContext()) + "add_inventory.php";
            Log.d("url------", url);

            ServiceHandler sh = new ServiceHandler();
            // Making a request to url and getting response
            result = sh.makeRequest(url, ServiceHandler.POST, json.toString());

        } catch (Throwable t) {
            Toast.makeText(this, "Request failed: " + t.toString(),Toast.LENGTH_LONG).show();
        }

    }

    private void setSpinnerData() {
        if (StaticData.isNetworkConnected(getApplicationContext())) {
            try {
                new AddInventoryActivity.GetDataOperation().execute();
            } catch (Exception e) {
                //e.printStackTrace();
            }
        } else {
            Toast.makeText(getApplicationContext(),
                    "Not connected to Internet", Toast.LENGTH_SHORT)
                    .show();
        }
    }

    private class GetDataOperation extends AsyncTask<String, Void, Void> {

        Dialog pDialog = new Dialog(AddInventoryActivity.this);

        protected void onPreExecute() {
            // Dialog.setMessage("Authanticating...");
            pDialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            pDialog.getWindow().setBackgroundDrawable(
                    new ColorDrawable(Color.TRANSPARENT));
            pDialog.setContentView(R.layout.custom_image_dialog);
            pDialog.show();
            pDialog.setCancelable(false);
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {

            getSpinnerData();

            try {
                JSONObject data = new JSONObject(result);
                JSONObject jsonLocation = data.getJSONObject("location");

                try {
                    Integer i = 0;
                    listLocation.add("");
                    while (jsonLocation.getString("a" + String.valueOf(i)) != null) {
                        listLocation.add(jsonLocation.getString("a" + String.valueOf(i)));
                        i++;
                    }
                }
                catch (JSONException e)
                {

                }

            } catch (JSONException e) {
                // TODO Auto-generated catch block
                //e.printStackTrace();
            } catch (NullPointerException n) {
                n.printStackTrace();
            }

            try {
                JSONObject data = new JSONObject(result);
                JSONObject jsonDescription = data.getJSONObject("description");

                try {
                    Integer i = 0;
                    listDescription.add("");
                    while (jsonDescription.getString("a" + String.valueOf(i)) != null) {
                        listDescription.add(jsonDescription.getString("a" + String.valueOf(i)));
                        i++;
                    }
                }
                catch (JSONException e)
                {

                }
            } catch (JSONException e) {
                // TODO Auto-generated catch block
                //e.printStackTrace();
            } catch (NullPointerException n) {
                n.printStackTrace();
            }


            return null;
        }

        protected void onPostExecute(Void unused) {

            try {
                if (pDialog.isShowing())
                    pDialog.dismiss();
                setSpinnerLocation();
                setSpinnerDescription();

            } catch (Exception e) {
                // TODO: handle exception
                //e.printStackTrace();
            }

        }
    }

    public void getSpinnerData() throws NullPointerException {
        // TODO Auto-generated method stub

        try {
            Log.d("data", "sent");
            JSONObject json = new JSONObject();

            String url = StaticData.getlink(getApplicationContext()) + "get_location_description.php";
            Log.d("url------", url);

            ServiceHandler sh = new ServiceHandler();
            // Making a request to url and getting response
            String jsonStr = sh.makeRequest(url, ServiceHandler.POST, json.toString());
            result = jsonStr;
        } catch (Throwable t) {
            Toast.makeText(this, "Request failed: " + t.toString(),Toast.LENGTH_LONG).show();
        }

    }





}





